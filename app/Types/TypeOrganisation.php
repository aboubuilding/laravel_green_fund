<?php

namespace App\Types;

class TypeOrganisation
{
    const ASSOCIATION_ONG = 1;
    const ENTREPRISE_PRIVEE = 2;
    const COLLECTIVITE_LOCALE = 3;
    const INSTITUTION_PUBLIQUE = 4;
    const GROUPEMENT_PRODUCTION = 5;

    public static function labels(): array
    {
        return [
            self::ASSOCIATION_ONG => 'Association / ONG',
            self::ENTREPRISE_PRIVEE => 'Entreprise privée',
            self::COLLECTIVITE_LOCALE => 'Collectivité locale',
            self::INSTITUTION_PUBLIQUE => 'Institution publique',
            self::GROUPEMENT_PRODUCTION => 'Groupement de production',
        ];
    }

    public static function badges(): array
    {
        return [
            self::ASSOCIATION_ONG => 'primary',
            self::ENTREPRISE_PRIVEE => 'success',
            self::COLLECTIVITE_LOCALE => 'warning',
            self::INSTITUTION_PUBLIQUE => 'danger',
            self::GROUPEMENT_PRODUCTION => 'info',
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

    public static function values(): array
    {
        return [
            self::ASSOCIATION_ONG,
            self::ENTREPRISE_PRIVEE,
            self::COLLECTIVITE_LOCALE,
            self::INSTITUTION_PUBLIQUE,
            self::GROUPEMENT_PRODUCTION,
        ];
    }

    public static function list(): array
    {
        return self::labels();
    }

    public static function isValid(int $type): bool
    {
        return in_array($type, self::values());
    }
}
