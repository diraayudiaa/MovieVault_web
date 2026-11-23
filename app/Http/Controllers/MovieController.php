<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Http;
use MongoDB\BSON\ObjectId;

class MovieController extends Controller
{
    /**
     * Mengubah MongoDB ObjectId menjadi UUID untuk Cassandra.
     */
    private function getCassandraMovieId($id)
    {
        $hex = strtolower((string) $id);

        return '00000000-'
            . substr($hex, 0, 4) . '-'
            . substr($hex, 4, 4) . '-'
            . substr($hex, 8, 4) . '-'
            . substr($hex, 12, 12);
    }

    /**
     * Mengambil review dari Cassandra.
     */
    private function getMovieReviews($movieId)
    {
        try {
            $response = Http::timeout(10)->get(
                'http://127.0.0.1:3001/api/reviews/' . $movieId
            );

            if ($response->successful()) {
                return $response->json('data', []);
            }
        } catch (\Exception $e) {
            // Jika Cassandra tidak tersedia, tampilkan tanpa review.
        }

        return [];
    }

    /**
     * Menghitung rata-rata rating review.
     */
    private function calculateAverageRating($reviews)
    {
        $ratings = array_map(
            fn ($review) => (float) ($review['rating'] ?? 0),
            $reviews
        );

        $count = count($ratings);

        return [
            'averageReviewRating' => $count > 0
                ? number_format(array_sum($ratings) / $count, 1)
                : '0.0',

            'reviewCount' => $count,
        ];
    }

    /**
     * Halaman daftar film.
     */
    public function index()
    {
        $redis = Redis::connection();
        $cacheKey = 'movie:all';

        $cachedMovies = $redis->get($cacheKey);

        if ($cachedMovies !== null) {
            $movies = unserialize($cachedMovies);
        } else {
            $movies = DB::connection('mongodb')
                ->getDatabase()
                ->selectCollection('movies')
                ->find([], ['sort' => ['title' => 1]])
                ->toArray();

            $redis->setex(
                $cacheKey,
                300,
                serialize($movies)
            );
        }

        // Ambil rating rata-rata dari Cassandra.
        foreach ($movies as &$movie) {
            $movieId = (string) $movie['_id'];

            $cassandraMovieId = $this->getCassandraMovieId($movieId);

            $reviews = $this->getMovieReviews($cassandraMovieId);

            $ratingData = $this->calculateAverageRating($reviews);

            $movie['average_review_rating'] = $ratingData['averageReviewRating'];
            $movie['review_count'] = $ratingData['reviewCount'];
        }

        unset($movie);

        // Ambil daftar film yang ada di Watchlist.
        $watchlistMovieIds = [];

        if (session()->has('user_id')) {
            $watchlistMovieIds = DB::connection('mysql_watchlist')
                ->table('watchlists')
                ->where('user_id', session('user_id'))
                ->pluck('movie_id')
                ->all();
        }

        return view('movies.index', compact(
            'movies',
            'watchlistMovieIds'
        ));
    }

    /**
     * Halaman detail film.
     */
    public function show($id)
    {
        if (!preg_match('/^[a-f0-9]{24}$/i', $id)) {
            abort(404);
        }

        $redis = Redis::connection();
        $cacheKey = 'movie:' . $id;

        $cachedMovie = $redis->get($cacheKey);

        if ($cachedMovie !== null) {
            $movie = unserialize($cachedMovie);
        } else {
            $movie = DB::connection('mongodb')
                ->getDatabase()
                ->selectCollection('movies')
                ->findOne([
                    '_id' => new ObjectId($id)
                ]);

            if (!$movie) {
                abort(404);
            }

            $redis->setex(
                $cacheKey,
                300,
                serialize($movie)
            );
        }

        if (!$movie) {
            abort(404);
        }

        // Ambil review dari Cassandra.
        $cassandraMovieId = $this->getCassandraMovieId($id);

        $reviews = $this->getMovieReviews($cassandraMovieId);

        // Hitung rata-rata rating.
        $ratingData = $this->calculateAverageRating($reviews);

        $averageReviewRating = $ratingData['averageReviewRating'];
        $reviewCount = $ratingData['reviewCount'];

        return view('movies.show', compact(
            'movie',
            'reviews',
            'averageReviewRating',
            'reviewCount',
            'id'
        ));
    }
}
