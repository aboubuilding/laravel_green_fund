<?php

namespace App\Types;

/**
 * Liste des statuts pour les actualités
 *
 * @author pmazama@gmail.com
 * @copyright HAMZ-Eng 2022
 * @version 1
 */
class StatutActualite
{
    const BROUILLON = 1;
    const PUBLIE = 2;

    /**
     * Libellés des statuts
     */
    public static function labels(): array
    {
        return [
            self::BROUILLON => 'Brouillon',
            self::PUBLIE => 'Publié',
        ];
    }

    /**
     * Couleurs des badges
     */
    public static function badges(): array
    {
        return [
            self::BROUILLON => 'secondary',
            self::PUBLIE => 'success',
        ];
    }

    /**
     * Icônes des statuts
     */
    public static function icons(): array
    {
        return [
            self::BROUILLON => 'fa-pencil',
            self::PUBLIE => 'fa-check-circle',
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
     * Vérifier si le statut est publié
     */
    public static function isPublished(int $statut): bool
    {
        return $statut === self::PUBLIE;
    }

    /**
     * Vérifier si le statut est brouillon
     */
    public static function isDraft(int $statut): bool
    {
        return $statut === self::BROUILLON;
    }

    /**
     * Statuts valides
     */
    public static function values(): array
    {
        return [
            self::BROUILLON,
            self::PUBLIE,
        ];
    }

    /**
     * Vérifier si une valeur est valide
     */
    public static function isValid(int $statut): bool
    {
        return in_array($statut, self::values());
    }
}
