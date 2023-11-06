<?php

namespace App\Http\Controllers;

use App\Enums\SavedAnimeStatusEnum;
use App\Models\SavedAnime;
use App\Services\JikanMoeAnimesService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $saved_animes = auth()->user()
            ? SavedAnime::home($request)->get()
            : collect([]);

        $saved_animes->map(
            fn ($saved_anime) => $saved_anime->details =
                JikanMoeAnimesService::findByMalId($saved_anime->mal_id)['data'] ??
                []
        );

        return inertia('Home', [
            'top_ten_animes' => JikanMoeAnimesService::getTopTen(),
            'saved_animes' => $saved_animes,
        ]);
    }
}
