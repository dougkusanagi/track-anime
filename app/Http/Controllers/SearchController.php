<?php

namespace App\Http\Controllers;

use App\Services\JikanMoeAnimesService;
use Illuminate\Http\Request;

class SearchController
{
    public function __invoke(Request $request)
    {
        return inertia('Search', [
            'animes' => JikanMoeAnimesService::queryFromRequest($request),
        ]);
    }
}
