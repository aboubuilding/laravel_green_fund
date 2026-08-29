<?php

namespace App\Types;

class StatutNewsletter
{
    const ACTIF = 'actif';
    const DESABONNE = 'desabonne';

    public static function labels(): array
    {
        return [
            self::ACTIF => 'Actif',
            self::DESABONNE => 'Désabonné',
        ];
    }

    public static function badges(): array
    {
        return [
            self::ACTIF => 'success',
            self::DESABONNE => 'danger',
        ];
    }

    public static function icons(): array
    {
        return [
            self::ACTIF => 'fa-check-circle',
            self::DESABONNE => 'fa-times-circle',
        ];
    }

    public static function getLabel(string $statut): string
    {
        return self::labels()[$statut] ?? 'Inconnu';
    }

    public static function getBadge(string $statut): string
    {
        return self::badges()[$statut] ?? 'secondary';
    }

    public static function getIcon(string $statut): string
    {
        return self::icons()[$statut] ?? 'fa-question';
    }

    public static function values(): array
    {
        return [self::ACTIF, self::DESABONNE];
    }

    public static function list(): array
    {
        return self::labels();
    }

    public static function isValid(string $statut): bool
    {
        return in_array($statut, self::values());
    }
}
