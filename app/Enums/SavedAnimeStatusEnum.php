<?php

namespace App\Enums;

enum SavedAnimeStatusEnum: string {
    case Watching = 'Watching';
    case PlanToWatch = 'Plan to Watch';
    case Completed = 'Completed';
    case Dropped = 'Dropped';
    case Paused = 'Paused';
    case Rewatching = 'Rewatching';

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
