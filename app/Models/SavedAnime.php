<?php

namespace App\Models;

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

    public function scopeHome(Builder $query, Request $request)
    {
        return $query
            ->where('user_id', auth()->user()->id)
            ->orderBy($request->get('orderBy') ?? 'last_watched_at', $request->get('sort') ?? 'desc')
            ->get();
    }
}
