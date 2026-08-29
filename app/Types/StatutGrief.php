<?php

namespace App\Types;

class StatutGrief
{
    const NOUVEAU = 'nouveau';
    const EN_COURS = 'en_cours';
    const RESOLU = 'resolu';

    public static function labels(): array
    {
        return [
            self::NOUVEAU => 'Nouveau',
            self::EN_COURS => 'En cours',
            self::RESOLU => 'Résolu',
        ];
    }

    public static function badges(): array
    {
        return [
            self::NOUVEAU => 'danger',
            self::EN_COURS => 'warning',
            self::RESOLU => 'success',
        ];
    }

    public static function icons(): array
    {
        return [
            self::NOUVEAU => 'fa-exclamation-circle',
            self::EN_COURS => 'fa-spinner',
            self::RESOLU => 'fa-check-circle',
        ];
    }

    public static function colors(): array
    {
        return [
            self::NOUVEAU => '#DC3545',
            self::EN_COURS => '#F5A623',
            self::RESOLU => '#2E8B57',
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
        return [self::NOUVEAU, self::EN_COURS, self::RESOLU];
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
