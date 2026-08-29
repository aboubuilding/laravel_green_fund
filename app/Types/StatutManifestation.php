<?php

namespace App\Types;

class StatutManifestation
{
    const NOUVEAU = 1;
    const TRAITE = 2;

    public static function labels(): array
    {
        return [
            self::NOUVEAU => 'Nouveau',
            self::TRAITE => 'Traité',
        ];
    }

    public static function badges(): array
    {
        return [
            self::NOUVEAU => 'danger',
            self::TRAITE => 'success',
        ];
    }

    public static function icons(): array
    {
        return [
            self::NOUVEAU => 'fa-envelope',
            self::TRAITE => 'fa-check-double',
        ];
    }

    public static function getLabel(int $statut): string
    {
        return self::labels()[$statut] ?? 'Inconnu';
    }

    public static function getBadge(int $statut): string
    {
        return self::badges()[$statut] ?? 'secondary';
    }

    public static function getIcon(int $statut): string
    {
        return self::icons()[$statut] ?? 'fa-question';
    }

    public static function values(): array
    {
        return [self::NOUVEAU, self::TRAITE];
    }

    public static function list(): array
    {
        return self::labels();
    }

    public static function isValid(int $statut): bool
    {
        return in_array($statut, self::values());
    }
}
