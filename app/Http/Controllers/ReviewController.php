<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReviewController extends Controller
{
    public function index()
    {
        // Arahkan pengguna untuk memilih film terlebih dahulu
        return redirect()
            ->route('movies.index')
            ->with('info', 'Pilih film untuk melihat dan memberikan review.');
    }

    public function store(Request $request, $id)
    {
        // Pastikan pengguna sudah login
        if (!session()->has('user_id')) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi MongoDB ObjectId
        if (!preg_match('/^[a-f0-9]{24}$/i', $id)) {
            abort(404);
        }

        // Validasi input review
        $validated = $request->validate([
            'rating' => ['required', 'numeric', 'min:1', 'max:10'],
            'comment' => ['required', 'string', 'max:2000'],
        ]);

        // Pemetaan MongoDB ObjectId menjadi UUID Cassandra
        $hex = strtolower($id);

        $cassandraMovieId = '00000000-'
            . substr($hex, 0, 4) . '-'
            . substr($hex, 4, 4) . '-'
            . substr($hex, 8, 4) . '-'
            . substr($hex, 12, 12);

        try {
            $response = Http::timeout(10)->post(
                'http://127.0.0.1:3001/api/reviews/' . $cassandraMovieId,
                [
                    'username' => session('username'),
                    'rating' => (float) $validated['rating'],
                    'comment' => $validated['comment'],
                ]
            );

            if ($response->successful()) {
                return redirect()
                    ->route('movies.show', ['id' => $id])
                    ->with('success', 'Review berhasil ditambahkan!');
            }

            return back()
                ->withInput()
                ->with(
                    'error',
                    $response->json('message', 'Gagal menyimpan review.')
                );

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Cassandra API tidak dapat diakses.');
        }
    }
}
