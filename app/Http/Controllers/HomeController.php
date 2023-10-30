<?php

namespace App\Http\Controllers;

use App\Models\SavedAnime;
use App\Services\JikanMoeAnimesService;

class HomeController extends Controller
{
    public function __invoke()
    {
        $saved_animes = auth()->user()
            ? SavedAnime::where('user_id', auth()->user()->id)->get()
            : [];

        return inertia('Home', [
            'animes' => JikanMoeAnimesService::getTopTen(),
            'saved_animes' => $saved_animes,
        ]);
    }
}
