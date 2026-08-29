<?php

namespace App\Types;

class StatutSoumission
{
    const EN_ATTENTE = 1;
    const EN_COURS = 2;
    const APPROUVE = 3;
    const REJETE = 4;

    public static function labels(): array
    {
        return [
            self::EN_ATTENTE => 'En attente',
            self::EN_COURS => 'En cours',
            self::APPROUVE => 'Approuvé',
            self::REJETE => 'Rejeté',
        ];
    }

    public static function badges(): array
    {
        return [
            self::EN_ATTENTE => 'warning',
            self::EN_COURS => 'primary',
            self::APPROUVE => 'success',
            self::REJETE => 'danger',
        ];
    }

    public static function icons(): array
    {
        return [
            self::EN_ATTENTE => 'fa-clock',
            self::EN_COURS => 'fa-spinner',
            self::APPROUVE => 'fa-check-circle',
            self::REJETE => 'fa-times-circle',
        ];
    }

    public static function colors(): array
    {
        return [
            self::EN_ATTENTE => '#ffc107',
            self::EN_COURS => '#007bff',
            self::APPROUVE => '#28a745',
            self::REJETE => '#dc3545',
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
        return [self::EN_ATTENTE, self::EN_COURS, self::APPROUVE, self::REJETE];
    }

    public static function list(): array
    {
        return self::labels();
    }

    public static function isValid(int $statut): bool
    {
        return in_array($statut, self::values());
    }

    public static function getProgress(int $statut): int
    {
        return match($statut) {
            self::EN_ATTENTE => 25,
            self::EN_COURS => 50,
            self::APPROUVE => 100,
            self::REJETE => 100,
            default => 0,
        };
    }
}
