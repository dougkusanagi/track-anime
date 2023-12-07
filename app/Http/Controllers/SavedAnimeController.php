<?php

namespace App\Http\Controllers;

use App\Models\SavedAnime;
use App\Services\JikanMoeAnimesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SavedAnimeController
{
    public function store(Request $request)
    {
        $anime = JikanMoeAnimesService::findByMalId($request->mal_id)['data'] ?? null;

        if (!$anime) {
            return to_route('home')
                ->with('error', 'Anime não encontrado.');
        }

        $user = auth()->user();
        $user->savedAnimes()->create([
            'mal_id' => $anime['mal_id'],
            'title' => $anime['title'],
            'image_cover_url' => $anime['images']['webp']['image_url'],
            'episode_count' => 0,
        ]);

        return to_route('home')
            ->with('success', 'Anime salvo com sucesso como (Assistindo).');
    }

    public function updateAnimeEpisode(Request $request)
    {
        SavedAnime::findOrFail($request->anime['id'])
            ->update([
                'episode_count' => $request->episode_count ?? 0,
            ]);

        Session::flash('success', 'Episódio atualizado com sucesso.');
    }

    public function updateAnimeLink(Request $request)
    {
        $anime = SavedAnime::findOrFail($request->id);
        $old_links = $anime->links ?? [];

        $anime->update([
            'links' => [...$old_links, $request->new_link],
        ]);

        Session::flash('success', 'Link salvo com sucesso.');
    }

    public function destroy(SavedAnime $anime)
    {
        if (!$anime->delete()) {
            return to_route('home')
                ->with('error', 'Anime não encontrado.');
        }

        Session::flash('success', 'Anime removido da lista.');
    }

    public function deleteLink(SavedAnime $anime, Request $request)
    {
        $anime->update([
            'links' => array_diff($anime->links, [$request->link]),
        ]);

        Session::flash('success', 'Link removido com sucesso.');
    }
}
