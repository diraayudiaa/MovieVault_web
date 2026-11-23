<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;

class WatchlistController extends Controller
{
    public function index()
    {
        // Pastikan pengguna sudah login
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $userId = session('user_id');

        // Ambil Watchlist milik pengguna yang sedang login
        $watchlists = DB::connection('mysql_watchlist')
            ->table('watchlists')
            ->where('user_id', $userId)
            ->orderByDesc('added_at')
            ->get();

        $collection = DB::connection('mongodb')
            ->getDatabase()
            ->selectCollection('movies');

        $movies = [];

        foreach ($watchlists as $item) {
            if (!preg_match('/^[a-f0-9]{24}$/i', $item->movie_id)) {
                continue;
            }

            $movie = $collection->findOne([
                '_id' => new ObjectId($item->movie_id)
            ]);

            if ($movie) {
                $movies[] = [
                    'movie' => $movie,
                    'added_at' => $item->added_at,
                ];
            }
        }

        return view('watchlist.index', compact('movies'));
    }

    public function store($movieId)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $userId = session('user_id');

        if (!preg_match('/^[a-f0-9]{24}$/i', $movieId)) {
            abort(404);
        }

        $movie = DB::connection('mongodb')
            ->getDatabase()
            ->selectCollection('movies')
            ->findOne([
                '_id' => new ObjectId($movieId)
            ]);

        if (!$movie) {
            abort(404);
        }

        // Simpan film untuk pengguna yang sedang login
        DB::connection('mysql_watchlist')
            ->table('watchlists')
            ->updateOrInsert(
                [
                    'user_id' => $userId,
                    'movie_id' => $movieId
                ],
                [
                    'added_at' => now()
                ]
            );

        return redirect()
            ->route('watchlist.index')
            ->with('success', 'Film berhasil ditambahkan ke Watchlist!');
    }

    public function destroy($movieId)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $userId = session('user_id');

        if (!preg_match('/^[a-f0-9]{24}$/i', $movieId)) {
            abort(404);
        }

        // Hanya hapus film milik pengguna yang sedang login
        DB::connection('mysql_watchlist')
            ->table('watchlists')
            ->where('user_id', $userId)
            ->where('movie_id', $movieId)
            ->delete();

        return redirect()
            ->route('watchlist.index')
            ->with('success', 'Film berhasil dihapus dari Watchlist!');
    }
}
