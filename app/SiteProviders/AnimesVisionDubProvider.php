<?php

namespace App\SiteProviders;

use App\Models\SavedAnime;

class AnimesVisionDubProvider
{
    public function __invoke(SavedAnime $saved_anime)
    {
        $title = str($saved_anime->title)->slug();
        $episode_count = str_pad($saved_anime->episode_count, 2, '0', STR_PAD_LEFT);

        return "https://animes.vision/animes/$title-dublado/episodio-$episode_count/dublado";
    }
}
