<?php

namespace App\Types;

class StatutPlainte
{
    const NOUVELLE = 'nouvelle';
    const EN_COURS = 'en_cours';
    const RESOLUE = 'resolue';

    public static function labels(): array
    {
        return [
            self::NOUVELLE => 'Nouvelle',
            self::EN_COURS => 'En cours',
            self::RESOLUE => 'Résolue',
        ];
    }

    public static function badges(): array
    {
        return [
            self::NOUVELLE => 'danger',
            self::EN_COURS => 'warning',
            self::RESOLUE => 'success',
        ];
    }

    public static function icons(): array
    {
        return [
            self::NOUVELLE => 'fa-exclamation-circle',
            self::EN_COURS => 'fa-spinner',
            self::RESOLUE => 'fa-check-circle',
        ];
    }

    public static function colors(): array
    {
        return [
            self::NOUVELLE => '#DC3545',
            self::EN_COURS => '#F5A623',
            self::RESOLUE => '#2E8B57',
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

    public static function getColor(string $statut): string
    {
        return self::colors()[$statut] ?? '#6c757d';
    }

    public static function values(): array
    {
        return [self::NOUVELLE, self::EN_COURS, self::RESOLUE];
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
