<?php

namespace App\Types;

/**
 * Liste des types d'événements
 *
 * @author pmazama@gmail.com
 * @copyright HAMZ-Eng 2022
 * @version 1
 */
class TypeEvenement
{
    const ATELIER = 1;
    const CONFERENCE = 2;
    const FORMATION = 3;

    /**
     * Libellés des types d'événements
     */
    public static function labels(): array
    {
        return [
            self::ATELIER => 'Atelier',
            self::CONFERENCE => 'Conférence',
            self::FORMATION => 'Formation',
        ];
    }

    /**
     * Couleurs des badges
     */
    public static function badges(): array
    {
        return [
            self::ATELIER => 'primary',
            self::CONFERENCE => 'info',
            self::FORMATION => 'success',
        ];
    }

    /**
     * Icônes des types d'événements
     */
    public static function icons(): array
    {
        return [
            self::ATELIER => 'fa-users-cog',
            self::CONFERENCE => 'fa-microphone',
            self::FORMATION => 'fa-chalkboard-teacher',
        ];
    }

    /**
     * Obtenir le libellé d'un type
     */
    public static function getLabel(int $type): string
    {
        return self::labels()[$type] ?? 'Inconnu';
    }

    /**
     * Obtenir la classe du badge
     */
    public static function getBadge(int $type): string
    {
        return self::badges()[$type] ?? 'secondary';
    }

    /**
     * Obtenir l'icône
     */
    public static function getIcon(int $type): string
    {
        return self::icons()[$type] ?? 'fa-question';
    }

    /**
     * Liste pour les selects
     */
    public static function list(): array
    {
        return self::labels();
    }

    /**
     * Vérifier si c'est un atelier
     */
    public static function isAtelier(int $type): bool
    {
        return $type === self::ATELIER;
    }

    /**
     * Vérifier si c'est une conférence
     */
    public static function isConference(int $type): bool
    {
        return $type === self::CONFERENCE;
    }

    /**
     * Vérifier si c'est une formation
     */
    public static function isFormation(int $type): bool
    {
        return $type === self::FORMATION;
    }

    /**
     * Types valides
     */
    public static function values(): array
    {
        return [
            self::ATELIER,
            self::CONFERENCE,
            self::FORMATION,
        ];
    }

    /**
     * Vérifier si une valeur est valide
     */
    public static function isValid(int $type): bool
    {
        return in_array($type, self::values());
    }

    /**
     * Obtenir les couleurs pour l'affichage
     */
    public static function colors(): array
    {
        return [
            self::ATELIER => '#007bff',
            self::CONFERENCE => '#17a2b8',
            self::FORMATION => '#28a745',
        ];
    }
}
