<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// Profile
Route::get('/profile', [AuthController::class, 'profile'])
    ->name('profile.index');

Route::put('/profile', [AuthController::class, 'updateProfile'])
    ->name('profile.update');

// Movies
Route::get('/movies', [MovieController::class, 'index'])
    ->name('movies.index');

Route::get('/movies/{id}', [MovieController::class, 'show'])
    ->name('movies.show');

// Reviews
Route::get('/reviews', [ReviewController::class, 'index'])
    ->name('reviews.index');

Route::post('/movies/{id}/reviews', [ReviewController::class, 'store'])
    ->name('reviews.store');

// Watchlist
Route::get('/watchlist', [WatchlistController::class, 'index'])
    ->name('watchlist.index');

Route::post('/watchlist/{movieId}', [WatchlistController::class, 'store'])
    ->name('watchlist.store');

Route::delete('/watchlist/{movieId}', [WatchlistController::class, 'destroy'])
    ->name('watchlist.destroy');

// Admin
Route::prefix('admin')
    ->middleware('admin')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])
            ->name('admin.index');

        Route::get('/movies/create', [AdminController::class, 'create'])
            ->name('admin.movies.create');

        Route::post('/movies', [AdminController::class, 'store'])
            ->name('admin.movies.store');

        Route::delete('/movies/{id}', [AdminController::class, 'destroy'])
            ->name('admin.movies.destroy');
    });
