<?php

namespace App\Types;

class StatutProjet
{
    const EN_COURS = 1;
    const TERMINE = 2;
    const A_VENIR = 3;

    public static function labels(): array
    {
        return [
            self::EN_COURS => 'En cours',
            self::TERMINE => 'Terminé',
            self::A_VENIR => 'À venir',
        ];
    }

    public static function badges(): array
    {
        return [
            self::EN_COURS => 'primary',
            self::TERMINE => 'success',
            self::A_VENIR => 'warning',
        ];
    }

    public static function icons(): array
    {
        return [
            self::EN_COURS => 'fa-spinner',
            self::TERMINE => 'fa-check-circle',
            self::A_VENIR => 'fa-clock',
        ];
    }

    public static function colors(): array
    {
        return [
            self::EN_COURS => '#007bff',
            self::TERMINE => '#28a745',
            self::A_VENIR => '#ffc107',
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

    public static function getColor(int $statut): string
    {
        return self::colors()[$statut] ?? '#6c757d';
    }

    public static function values(): array
    {
        return [self::EN_COURS, self::TERMINE, self::A_VENIR];
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
