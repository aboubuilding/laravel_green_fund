<?php

namespace App\Types;

class CategorieDocument
{
    const PLAN = 1;
    const POLITIQUE = 2;
    const DECRET = 3;
    const RAPPORT = 4;
    const GUIDE = 5;
    const AUTRE = 6;

    public static function labels(): array
    {
        return [
            self::PLAN => 'Plan',
            self::POLITIQUE => 'Politique',
            self::DECRET => 'Décret',
            self::RAPPORT => 'Rapport',
            self::GUIDE => 'Guide',
            self::AUTRE => 'Autre',
        ];
    }

    public static function badges(): array
    {
        return [
            self::PLAN => 'primary',
            self::POLITIQUE => 'danger',
            self::DECRET => 'warning',
            self::RAPPORT => 'info',
            self::GUIDE => 'success',
            self::AUTRE => 'secondary',
        ];
    }

    public static function getLabel(int $categorie): string
    {
        return self::labels()[$categorie] ?? 'Inconnu';
    }

    public static function getBadge(int $categorie): string
    {
        return self::badges()[$categorie] ?? 'secondary';
    }

    public static function values(): array
    {
        return array_keys(self::labels());
    }

    public static function list(): array
    {
        return self::labels();
    }
}
