<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'full_name' => 'required|string|max:100',
        ]);

        $userId = DB::table('users')->insertGetId([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'full_name' => $validated['full_name'],
            'bio' => null,
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ], 'user_id');

        $user = DB::table('users')
            ->where('user_id', $userId)
            ->first();

        $request->session()->regenerate();

        session([
            'user_id' => $user->user_id,
            'username' => $user->username,
            'role' => $user->role,
        ]);

        return redirect()
            ->route('profile.index')
            ->with('success', 'Registrasi berhasil! Selamat datang di MovieVault.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = DB::table('users')
            ->where('username', $credentials['login'])
            ->orWhere('email', $credentials['login'])
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password_hash)) {
            return back()
                ->withErrors([
                    'login' => 'Username, email, atau password salah.'
                ])
                ->onlyInput('login');
        }

        $request->session()->regenerate();

        session([
            'user_id' => $user->user_id,
            'username' => $user->username,
            'role' => $user->role,
        ]);

        // Admin masuk ke dashboard admin
        if ($user->role === 'admin') {
            return redirect()
                ->route('admin.index')
                ->with('success', 'Login admin berhasil!');
        }

        // User masuk ke halaman daftar film
        return redirect()
            ->route('movies.index')
            ->with('success', 'Login berhasil! Selamat datang kembali.');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Kamu berhasil logout.');
    }

    public function profile()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        // Admin tidak menggunakan halaman profile user
        if (session('role') === 'admin') {
            return redirect()->route('admin.index');
        }

        $user = DB::table('users')
            ->where('user_id', session('user_id'))
            ->first();

        if (!$user) {
            abort(404);
        }

        return view('profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        // Admin tidak dapat mengubah profile melalui fitur user
        if (session('role') === 'admin') {
            return redirect()->route('admin.index');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . session('user_id') . ',user_id',
            'bio' => 'nullable|string|max:500',
        ]);

        DB::table('users')
            ->where('user_id', session('user_id'))
            ->update([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'bio' => $validated['bio'] ?? null,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('profile.index')
            ->with('success', 'Profile berhasil diperbarui.');
    }
}
