<?php

namespace App\Services;

use App\Models\SavedAnime;
use App\SiteProviders\AnimeFireDubProvider;
use App\SiteProviders\AnimesHouseProvider;
use App\SiteProviders\AnimesOnlineHdVip;
use App\SiteProviders\AnimesVisionProvider;
use App\SiteProviders\AnimesOnlineProvider;
use App\SiteProviders\AnimesVisionDubProvider;

class ProvidedLinksService
{
    private $site_providers = [
        'animes.vision' => AnimesVisionProvider::class,
        '(DUB)animes.vision' => AnimesVisionDubProvider::class,
        'animeshouse.net' => AnimesHouseProvider::class,
        'animesonlinecc.to' => AnimesOnlineProvider::class,
        // 'animesonlinehd.vip' => AnimesOnlineHdVip::class,
        '(DUB)animefire.plus' => AnimeFireDubProvider::class,
    ];

    public function __invoke(SavedAnime $saved_anime)
    {
        return array_map(
            fn ($provider) => (new $provider)($saved_anime),
            $this->site_providers
        );
    }
}
