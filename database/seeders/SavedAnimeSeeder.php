<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SavedAnimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Douglas Lopes',
            'email' => 'dl.aguiar@yahoo.com.br',
            'password' => bcrypt('Sh@d0w'),
        ]);

        $anime = [
            'user_id' => $user->id,
            'mal_id' => 1535,
            'title' => 'Death Note',
            'notes' => null,
            'status' => 'Watching',
            'score' => 'Zero',
            'rewatch_count' => 0,
            'episode_count' => 4,
            'favorite' => 0,
            'links' => [
                'https://animes.vision/animes/tate-no-yuusha-no-nariagari-2',
                'https://animeshouse.net/',
            ],
            'image_cover_url' => 'https://cdn.myanimelist.net/images/anime/1079/138100.webp',
        ];

        foreach (range(1, 30) as $i) {
            \App\Models\SavedAnime::factory()->create($anime);
        }
    }
}
