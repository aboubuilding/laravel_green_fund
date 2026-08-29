<?php

namespace App\Types;

class StatutActualite
{
    const BROUILLON = 1;
    const PUBLIE = 2;

    public static function labels(): array
    {
        return [
            self::BROUILLON => 'Brouillon',
            self::PUBLIE => 'Publié',
        ];
    }

    public static function badges(): array
    {
        return [
            self::BROUILLON => 'secondary',
            self::PUBLIE => 'success',
        ];
    }

    public static function icons(): array
    {
        return [
            self::BROUILLON => 'fa-pencil',
            self::PUBLIE => 'fa-check-circle',
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
        return [self::BROUILLON, self::PUBLIE];
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
