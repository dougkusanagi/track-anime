<?php

namespace App\Services;

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

        return cache()
            ->remember(
                $query,
                now()->addDays(1),
                fn () => Http::get(self::BASE_URL . '/anime?' . $query)->json()
            );
    }

    public static function queryFromRequest(Request $request)
    {
        $query = http_build_query([
            'q' => $request->q,
        ]);

        return cache()
            ->remember(
                $query,
                now()->addDays(1),
                fn () => Http::get(self::BASE_URL . '/anime?' . $query)->json()
            );
    }

    public static function findByMalId(int $mal_id)
    {
        $instance = new self();

        $cached = cache()
            ->remember(
                'mal_id_' . $mal_id,
                now()->addDays(1),
                fn () => $instance->byMalId($mal_id)
            );

        if ($cached) {
            return $cached;
        }

        return $instance->byMalId($mal_id);
    }

    private function byMalId(int $mal_id)
    {
        return Http::get(self::BASE_URL . '/anime/' . $mal_id)->json();
    }

    public static function getTopTen()
    {
        $query = http_build_query([
            'limit' => 10,
            'order_by' => 'popularity',
        ]);

        return cache()
            ->remember(
                'top_ten_animes',
                now()->addDays(1),
                fn () => Http::get(self::BASE_URL . '/anime?' . $query)->json()
            );
    }
}
