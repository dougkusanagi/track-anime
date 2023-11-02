<?php

namespace App\Enums;

enum SavedAnimeStatusEnum: string
{
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

    public static function getSelectArrayPt()
    {
        return [
            'Assistindo' => self::Watching->value,
            'Planejo assistir' => self::PlanToWatch->value,
            'Completo' => self::Completed->value,
            'Dropado' => self::Dropped->value,
            'Pausado' => self::Paused->value,
            'Reassistindo' => self::Rewatching->value,
        ];
    }
}
