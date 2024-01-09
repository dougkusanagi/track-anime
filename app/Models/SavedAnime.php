<?php

namespace App\Models;

use App\Enums\SavedAnimeStatusEnum;
use App\Services\ProvidedLinksService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SavedAnime extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'links' => 'array',
        // 'provided_links' => 'array',
    ];

    protected $appends = [
        'provided_links',
    ];

    protected function getProvidedLinksAttribute()
    {
        $title = str($this->title)->slug();
        $episode_count = str_pad($this->episode_count, 2, '0', STR_PAD_LEFT);
        return [
            'animes.vision' => "https://animes.vision/animes/$title/episodio-$episode_count/legendado",
            'animeshouse.net' => "https://animeshouse.net/episodio/$title-s1-episodio-$this->episode_count-legendado-hd",
        ];
    }

    public function scopeHome(Builder $query, Request $request): Builder
    {
        $order_by = $request->get('orderBy') ?? 'last_watched_at';
        $sort = $request->get('sort') ?? 'desc';
        $status = $request->has('status')
            ? $request->get('status')
            : SavedAnimeStatusEnum::Watching->value;

        return $query
            ->where('user_id', auth()->user()->id)
            ->when(
                $status,
                fn ($query) => $query->where('status', $status)
            )
            ->orderBy($order_by, $sort);
    }
}
