<?php

namespace App\SiteProviders;

use App\Models\SavedAnime;

class AnimesHouseProvider
{
    public function __invoke(SavedAnime $saved_anime)
    {
        $title = str($saved_anime->title)->slug();

        return "https://animeshouse.net/episodio/$title-s1-episodio-$saved_anime->episode_count-legendado-hd";
    }
}
