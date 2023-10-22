<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class JikanMoeAnimesService
{
    const BASE_URL = 'https://api.jikan.moe/v4';

    // Replace params with dto class
    public static function query(
        string $q = '',
        string $order_by = 'mal_id',
        int $limit = 10,
        int $page = 1,
        string $type = 'tv'
    ): array {
        $query = http_build_query([
            'q' => $q,
            'order_by' => $order_by,
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

    public static function byMalId(int $mal_id)
    {
        return cache()
            ->remember(
                'mal_id_' . $mal_id,
                now()->addDays(1),
                fn () => Http::get(self::BASE_URL . '/anime/' . $mal_id)->json()
            );
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

    public static function getAnimeBanner(int $mal_id)
    {
        $url = 'https://shikimori.one/api/doc/graphql';

        $query = <<<GRAPHQL
            query getUsers {
                user {
                    id
                    name
                }
            }
        GRAPHQL;

        $response = (new Client())->request('post', '{graphql-endpoint}', [
            'headers' => [
                'Authorization' => 'bearer ' . $token,
                'Content-Type' => 'application/json'
            ],
            'body' => $graphQLquery
        ]);
    }

    public function graphqlQuery($endPoint, $query, $accessToken)
    {
        $response = new Client([
            'base_uri' => $endPoint,
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'query' => $query,
            ]),
        ]);

        return collect(json_decode($response->getBody()->getContents(), true));
    }
}
