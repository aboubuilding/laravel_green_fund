<?php

namespace App\Types;

/**
 * Liste des statuts pour les projets
 *
 * @author pmazama@gmail.com
 * @copyright HAMZ-Eng 2022
 * @version 1
 */
class StatutProjet
{
    const EN_COURS = 1;
    const TERMINE = 2;
    const A_VENIR = 3;

    /**
     * Libellés des statuts
     */
    public static function labels(): array
    {
        return [
            self::EN_COURS => 'En cours',
            self::TERMINE => 'Terminé',
            self::A_VENIR => 'À venir',
        ];
    }

    /**
     * Couleurs des badges
     */
    public static function badges(): array
    {
        return [
            self::EN_COURS => 'primary',
            self::TERMINE => 'success',
            self::A_VENIR => 'warning',
        ];
    }

    /**
     * Icônes des statuts
     */
    public static function icons(): array
    {
        return [
            self::EN_COURS => 'fa-spinner',
            self::TERMINE => 'fa-check-circle',
            self::A_VENIR => 'fa-clock',
        ];
    }

    /**
     * Obtenir le libellé d'un statut
     */
    public static function getLabel(int $statut): string
    {
        return self::labels()[$statut] ?? 'Inconnu';
    }

    /**
     * Obtenir la classe du badge
     */
    public static function getBadge(int $statut): string
    {
        return self::badges()[$statut] ?? 'secondary';
    }

    /**
     * Obtenir l'icône
     */
    public static function getIcon(int $statut): string
    {
        return self::icons()[$statut] ?? 'fa-question';
    }

    /**
     * Liste pour les selects
     */
    public static function list(): array
    {
        return self::labels();
    }

    /**
     * Vérifier si le projet est en cours
     */
    public static function isEnCours(int $statut): bool
    {
        return $statut === self::EN_COURS;
    }

    /**
     * Vérifier si le projet est terminé
     */
    public static function isTermine(int $statut): bool
    {
        return $statut === self::TERMINE;
    }

    /**
     * Vérifier si le projet est à venir
     */
    public static function isAVenir(int $statut): bool
    {
        return $statut === self::A_VENIR;
    }

    /**
     * Statuts valides
     */
    public static function values(): array
    {
        return [
            self::EN_COURS,
            self::TERMINE,
            self::A_VENIR,
        ];
    }

    /**
     * Vérifier si une valeur est valide
     */
    public static function isValid(int $statut): bool
    {
        return in_array($statut, self::values());
    }

    /**
     * Obtenir les couleurs pour l'affichage
     */
    public static function colors(): array
    {
        return [
            self::EN_COURS => '#007bff',
            self::TERMINE => '#28a745',
            self::A_VENIR => '#ffc107',
        ];
    }

    /**
     * Obtenir le pourcentage de progression (pour les projets en cours)
     */
    public static function getProgress(int $statut): ?int
    {
        return match($statut) {
            self::EN_COURS => 50,
            self::TERMINE => 100,
            self::A_VENIR => 0,
            default => null,
        };
    }
}
