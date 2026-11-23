<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan pengguna sudah login
        if (!session()->has('user_id')) {
            return redirect()
                ->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Pastikan pengguna memiliki role admin
        if (session('role') !== 'admin') {
            abort(403, 'Akses ditolak. Halaman ini khusus Admin.');
        }

        return $next($request);
    }
}
