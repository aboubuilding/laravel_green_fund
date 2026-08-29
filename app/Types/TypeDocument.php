<?php

namespace App\Types;

class TypeDocument
{
    const RAPPORT = 'rapport';
    const GUIDE = 'guide';
    const BROCHURE = 'brochure';
    const FORMULAIRE = 'formulaire';
    const CONTRAT = 'contrat';
    const AUTRE = 'autre';

    public static function labels(): array
    {
        return [
            self::RAPPORT => 'Rapport',
            self::GUIDE => 'Guide',
            self::BROCHURE => 'Brochure',
            self::FORMULAIRE => 'Formulaire',
            self::CONTRAT => 'Contrat',
            self::AUTRE => 'Autre',
        ];
    }

    public static function badges(): array
    {
        return [
            self::RAPPORT => 'primary',
            self::GUIDE => 'success',
            self::BROCHURE => 'info',
            self::FORMULAIRE => 'warning',
            self::CONTRAT => 'danger',
            self::AUTRE => 'secondary',
        ];
    }

    public static function getLabel(string $type): string
    {
        return self::labels()[$type] ?? 'Inconnu';
    }

    public static function getBadge(string $type): string
    {
        return self::badges()[$type] ?? 'secondary';
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
