<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JikanMoeAnimesService
{
    const BASE_URL = 'https://api.jikan.moe/v4';

    // Replace params with dto class
    public static function query(
        string $q = '',
        string $order_by = '',
        string $sort = 'asc',
        int $limit = 10,
        int $page = 1,
        string $type = 'tv'
    ): array {
        $query = http_build_query([
            'q' => $q,
            'order_by' => $order_by,
            'sort' => $sort,
            'limit' => $limit,
            'page' => $page,
            'type' => $type,
        ]);

        return cache()->remember(
            $query,
            now()->addDays(1),
            fn () => Http::get(self::BASE_URL . '/anime?' . $query)->json()
        );
    }

    public static function queryFromRequestCached(Request $request)
    {
        $query = http_build_query([
            'q' => $request->q,
        ]);

        return cache()->remember(
            $query,
            now()->addDays(1),
            fn () => self::queryFromRequest($request)
        );
    }

    public static function queryFromRequest(Request $request)
    {
        $query = http_build_query([
            'q' => $request->q,
        ]);

        return ($response = Http::get(self::BASE_URL . '/anime?' . $query))->failed()
            ? []
            : $response->collect('data');
    }

    public static function getTopTen(): array
    {
        $query = http_build_query([
            'limit' => 10,
            'order_by' => 'popularity',
        ]);

        return cache()->remember(
            'top_ten_animes',
            now()->addDays(1),
            fn () => Http::get(self::BASE_URL . '/anime?' . $query)
                ->json()
        );
    }

    public static function byMalIdCached(int $mal_id): array
    {
        $cache = cache('mal_id_' . $mal_id);

        if ($cache) {
            return $cache;
        }

        return cache()->remember(
            'mal_id_' . $mal_id,
            now()->addDays(1),
            fn () => self::byMalId($mal_id)
        );
    }

    public static function byMalId(int $mal_id): array
    {
        $response = Http::get(self::BASE_URL . '/anime/' . $mal_id);

        return !$response->failed()
            ? ['data' => self::toResource($response)]
            : [];
    }

    private static function toResource(Response $response)
    {
        return $response
            ->collect('data')
            ->only([
                'mal_id', 'title', 'images', 'status', 'episodes', 'type', 'synopsis', 'genres', 'score', 'year', 'airing', 'season'
            ])
            ->toArray();
    }
}
