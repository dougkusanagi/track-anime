<?php

namespace App\Http\Controllers;

use App\Models\SavedAnime;
use App\Services\JikanMoeAnimesService;

class HomeController extends Controller
{
    public function __invoke()
    {
        $saved_animes = auth()->user()
            ? SavedAnime::where('user_id', auth()->user()->id)->orderBy('last_watched_at', 'desc')->latest()->get()
            : collect([]);

        $saved_animes->map(
            fn ($saved_anime) => $saved_anime->details =
                JikanMoeAnimesService::findByMalId($saved_anime->mal_id)['data'] ??
                []
        );

        return inertia('Home', [
            'animes' => JikanMoeAnimesService::getTopTen(),
            'saved_animes' => $saved_animes,
        ]);
    }
}
