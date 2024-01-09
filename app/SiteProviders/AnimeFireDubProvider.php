<?php

namespace App\SiteProviders;

use App\Models\SavedAnime;

class AnimeFireDubProvider
{
    public function __invoke(SavedAnime $saved_anime)
    {
        // https://animefire.plus/animes/kamisama-hajimemashita-dublado/1
        $title = str($saved_anime->title)->slug();

        return "https://animefire.plus/animes/$title/dublado";
    }
}
