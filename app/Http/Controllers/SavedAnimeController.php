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
        $anime = JikanMoeAnimesService::byMalId($request->mal_id)['data'] ?? null;

        if (!$anime) {
            return to_route('home')->with('error', 'Anime não encontrado.');
        }

        /** @var \App\Models\User */
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
        SavedAnime::find($request->saved_anime['id'])->update([
            'episode_count' => $request->episode_count,
        ]);

        Session::flash('success', 'Episódio atualizado com sucesso.');
    }

    public function updateAnimeLink(Request $request)
    {
        SavedAnime::find($request->id)->update([
            'link' => $request->link,
        ]);

        Session::flash('success', 'Link salvo com sucesso.');
    }

    public function destroy(Request $request)
    {
        dd($request->all());
        $anime = SavedAnime::find($request->id);

        if (!$anime) {
            return to_route('home')->with('error', 'Anime não encontrado.');
        }

        $anime->delete();

        Session::flash('success', 'Anime excluído com sucesso da lista.');
    }
}
