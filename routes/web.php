<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SavedAnimeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return inertia('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/home', HomeController::class)->middleware(['auth', 'verified'])->name('home');

Route::controller(SavedAnimeController::class)->group(function () {
    Route::post('/saved-anime', 'store')->name('saved-animes.store');
    Route::put('/saved-anime/update-episode', 'updateAnimeEpisode')->name('saved-animes.save-episode');
    Route::put('/saved-anime/update-link', 'updateAnimeLink')->name('saved-animes.update-link');
    Route::delete('/saved-anime', 'destroy')->name('saved-animes.destroy');
})->middleware(['auth']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
