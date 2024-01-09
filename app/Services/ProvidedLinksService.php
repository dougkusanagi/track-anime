<?php

namespace App\Services;

use App\Models\SavedAnime;
use App\SiteProviders\AnimesHouseProvider;
use App\SiteProviders\AnimesVisionProvider;

class ProvidedLinksService
{
    private $site_providers = [
        'animes.vision' => AnimesVisionProvider::class,
        'animeshouse.net' => AnimesHouseProvider::class,
    ];

    public function __invoke(SavedAnime $saved_anime)
    {
        return array_map(
            fn ($provider) => $provider($saved_anime),
            $this->site_providers
        );
    }
}
