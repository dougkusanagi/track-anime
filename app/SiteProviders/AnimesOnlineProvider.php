<?php

namespace App\SiteProviders;

use App\Models\SavedAnime;

class AnimesOnlineProvider
{
    public function __invoke(SavedAnime $saved_anime)
    {
        $title = str($saved_anime->title)->slug();

        return "https://animesonline.nz/episodio/$title-episodio-$saved_anime->episode_count/";
    }
}
