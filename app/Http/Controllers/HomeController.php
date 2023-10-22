<?php

namespace App\Http\Controllers;

use App\Models\SavedAnime;
use App\Services\JikanMoeAnimesService;

class HomeController extends Controller
{
    public function __invoke()
    {
        return inertia('Home', [
            'animes' => JikanMoeAnimesService::getTopTen(),
            'saved_animes' => SavedAnime::where('user_id', auth()->user()->id)->get(),
        ]);
    }
}
