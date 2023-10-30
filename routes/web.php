<?php

use App\Http\Controllers\AnimeApiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SavedAnimeController;
use App\Http\Controllers\SearchController;
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

// Route::get('/', function () {
//     return inertia('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', fn() => redirect()->route('home'));
Route::get('/home', HomeController::class)->name('home');
Route::get('/search', SearchController::class)->name('search');

Route::controller(SavedAnimeController::class)->group(function () {
    Route::post('/saved-anime', 'store')->name('saved-anime.store');
    Route::put('/saved-anime/update-episode', 'updateAnimeEpisode')->name('saved-anime.save-episode');
    Route::put('/saved-anime/update-link', 'updateAnimeLink')->name('saved-anime.update-link');
    Route::put('/saved-anime/delete-link/{anime}', 'deleteLink')->name('saved-anime.delete-link');
    Route::delete('/saved-anime/delete/{anime}', 'destroy')->name('saved-anime.destroy');
})->middleware(['auth']);

Route::controller(AnimeApiController::class)->group(function () {
    Route::get('/anime-details/{mal_id}', 'getByMalId')->name('anime-details');
})->middleware(['auth']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
