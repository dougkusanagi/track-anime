<?php

namespace App\Services;

use App\Models\SavedAnime;
use App\SiteProviders\AnimesHouseProvider;
use App\SiteProviders\AnimesVisionProvider;
use App\SiteProviders\AnimesOnlineProvider;

class ProvidedLinksService
{
    private $site_providers = [
        'animes.vision' => AnimesVisionProvider::class,
        'animeshouse.net' => AnimesHouseProvider::class,
        'animesonlinecc.to' => AnimesOnlineProvider::class,
    ];

    public function __invoke(SavedAnime $saved_anime)
    {
        return array_map(
            fn ($provider) => (new $provider)($saved_anime),
            $this->site_providers
        );
    }
}
