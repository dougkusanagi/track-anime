<?php

namespace App\SiteProviders;

use App\Models\SavedAnime;

class AnimesHouseProvider
{
    public function __invoke(SavedAnime $saved_anime)
    {
        $title = str($saved_anime->title)->slug();

        $url = "https://animeshouse.net/episodio/$title-episodio-$saved_anime->episode_count-legendado-hd";

        $url = str_replace('2nd-season', 's2', $url);
        $url = str_replace('2nd', 's2', $url);

        return $url;
    }
}
