<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use MongoDB\BSON\ObjectId;

class AdminController extends Controller
{
    public function index()
    {
        $movies = DB::connection('mongodb')
            ->getDatabase()
            ->selectCollection('movies')
            ->find([], [
                'sort' => ['title' => 1]
            ])
            ->toArray();

        $totalMovies = count($movies);
        $totalUsers = DB::table('users')->count();

        return view('admin.index', compact(
            'movies',
            'totalMovies',
            'totalUsers'
        ));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'release_year' => 'required|integer|min:1888|max:' . (date('Y') + 5),
            'director' => 'required|string|max:255',
            'cast' => 'required|string|max:1000',
        ]);

        $genre = array_values(array_filter(
            array_map('trim', explode(',', $validated['genre']))
        ));

        $cast = array_values(array_filter(
            array_map('trim', explode(',', $validated['cast']))
        ));

        DB::connection('mongodb')
            ->getDatabase()
            ->selectCollection('movies')
            ->insertOne([
                'title' => $validated['title'],
                'genre' => $genre,
                'description' => $validated['description'],
                'release_year' => (int) $validated['release_year'],
                'director' => $validated['director'],
                'cast' => $cast,
                'rating' => 0,
            ]);

        Redis::connection()->del('movie:all');

        return redirect()
            ->route('admin.index')
            ->with('success', 'Film berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        if (!preg_match('/^[a-f0-9]{24}$/i', $id)) {
            abort(404);
        }

        DB::connection('mongodb')
            ->getDatabase()
            ->selectCollection('movies')
            ->deleteOne([
                '_id' => new ObjectId($id)
            ]);

        $redis = Redis::connection();
        $redis->del('movie:all');
        $redis->del('movie:' . $id);
        $redis->del('rating:' . $id);

        return redirect()
            ->route('admin.index')
            ->with('success', 'Film berhasil dihapus!');
    }
}
