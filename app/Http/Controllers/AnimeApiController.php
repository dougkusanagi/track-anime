<?php

namespace App\Http\Controllers;

use App\Services\JikanMoeAnimesService;

class AnimeApiController
{
    public function getByMalId(int $mal_id)
    {
        $anime = JikanMoeAnimesService::byMalIdCached($mal_id)['data'] ?? null;

        return response()->json($anime);
    }
}
