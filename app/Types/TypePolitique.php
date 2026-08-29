<?php

namespace App\Types;

class TypePolitique
{
    const POLITIQUE_GENERALE = 1;
    const POLITIQUE_FINANCIERE = 2;
    const POLITIQUE_RH = 3;
    const POLITIQUE_ENVIRONNEMENTALE = 4;
    const POLITIQUE_ACHATS = 5;
    const POLITIQUE_QUALITE = 6;
    const AUTRE = 7;

    public static function labels(): array
    {
        return [
            self::POLITIQUE_GENERALE => 'Politique générale',
            self::POLITIQUE_FINANCIERE => 'Politique financière',
            self::POLITIQUE_RH => 'Politique RH',
            self::POLITIQUE_ENVIRONNEMENTALE => 'Politique environnementale',
            self::POLITIQUE_ACHATS => 'Politique d\'achats',
            self::POLITIQUE_QUALITE => 'Politique qualité',
            self::AUTRE => 'Autre',
        ];
    }

    public static function badges(): array
    {
        return [
            self::POLITIQUE_GENERALE => 'primary',
            self::POLITIQUE_FINANCIERE => 'success',
            self::POLITIQUE_RH => 'info',
            self::POLITIQUE_ENVIRONNEMENTALE => 'success',
            self::POLITIQUE_ACHATS => 'warning',
            self::POLITIQUE_QUALITE => 'danger',
            self::AUTRE => 'secondary',
        ];
    }

    public static function icons(): array
    {
        return [
            self::POLITIQUE_GENERALE => 'fa-building',
            self::POLITIQUE_FINANCIERE => 'fa-coins',
            self::POLITIQUE_RH => 'fa-users',
            self::POLITIQUE_ENVIRONNEMENTALE => 'fa-leaf',
            self::POLITIQUE_ACHATS => 'fa-shopping-cart',
            self::POLITIQUE_QUALITE => 'fa-check-circle',
            self::AUTRE => 'fa-file-alt',
        ];
    }

    public static function getLabel(int $type): string
    {
        return self::labels()[$type] ?? 'Inconnu';
    }

    public static function getBadge(int $type): string
    {
        return self::badges()[$type] ?? 'secondary';
    }

    public static function getIcon(int $type): string
    {
        return self::icons()[$type] ?? 'fa-file';
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
