<?php

namespace App\Http\Middleware;

use App\Enums\SavedAnimeStatusEnum;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string | null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'flash' => [
                'message' => fn () => session('message'),
                'success' => fn () => session('success'),
                'info' => fn () => session('info'),
                'warning' => fn () => session('warning'),
                'error' => fn () => session('error'),
            ],
            'saved_anime_status_list' => SavedAnimeStatusEnum::getSelectArrayPt(),
        ];
    }
}
