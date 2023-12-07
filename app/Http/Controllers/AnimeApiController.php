<?php

namespace App\Http\Controllers;

use App\Services\JikanMoeAnimesService;

class AnimeApiController
{
    public function getByMalId(int $mal_id)
    {
        $anime = JikanMoeAnimesService::byMalIdCached($mal_id);

        return response()->json($anime ? $anime['data'] : null);
    }
}
