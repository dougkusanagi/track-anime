<?php

namespace App\Models;

use App\Enums\SavedAnimeStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SavedAnime extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'links' => 'array',
    ];

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
