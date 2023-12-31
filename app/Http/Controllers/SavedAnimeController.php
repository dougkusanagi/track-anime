<?php

namespace App\Http\Controllers;

use App\Enums\SavedAnimeStatusEnum;
use App\Models\SavedAnime;
use App\Services\JikanMoeAnimesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SavedAnimeController
{
    public function store(Request $request)
    {
        /** @var \App\Models\User */
        $user = auth()->user();
        if (!$user) {
            return back()
                ->with('error', 'Para salvar um anime, é preciso estar logado.');
        }

        if ($this->alreadyExists($request)) {
            return to_route('home')
                ->with('error', 'Este anime já está na sua lista.');
        }

        $anime = JikanMoeAnimesService::byMalIdCached($request->mal_id)['data'] ?? null;

        if (!$anime) {
            return to_route('home')
                ->with('error', 'Anime não encontrado.');
        }

        $user->savedAnimes()->create([
            'mal_id' => $anime['mal_id'],
            'title' => $anime['title'],
            'image_cover_url' => $anime['images']['webp']['image_url'],
            'episode_count' => 1,
        ]);

        return to_route('home')
            ->with('success', 'Anime salvo com sucesso como (Assistindo).');
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $status = $request->status
            ? SavedAnimeStatusEnum::from($request->status)
            : SavedAnimeStatusEnum::Watching;

        SavedAnime::findOrFail($request->id)
            ->update([
                'status' => $status,
                'rewatch_count' => $request->rewatch_count,
                'score' => $request->score,
            ]);

        return back()
            ->with('success', 'Informações atualizadas com sucesso.');
    }

    public function updateAnimeEpisode(Request $request)
    {
        SavedAnime::findOrFail($request->anime['id'])
            ->update([
                'episode_count' => $request->episode_count ?? 0,
                'last_watched_at' => now(),
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

    private function alreadyExists(Request $request)
    {
        return (bool) SavedAnime::query()
            ->where('mal_id', $request->mal_id)
            ->where('user_id', auth()->user()->id)
            ->first();
    }
}
