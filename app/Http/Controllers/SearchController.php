<?php

namespace App\Http\Controllers;

use App\Models\SavedAnime;
use App\Services\JikanMoeAnimesService;
use Illuminate\Http\Request;

class SearchController
{
    public function __invoke(Request $request)
    {
        return inertia('Search', [
            'animes' => JikanMoeAnimesService::queryFromRequest($request)['data'] ?? [],
            'already_on_list' => SavedAnime::all()->pluck('mal_id')->toArray(),
        ]);
    }
}
