<?php

namespace App\Types;

/**
 * Liste des différents états des modèles
 *
 * @author aboukadani@gmail.com
 * @copyright ABOU-DEV  2026
 * @version 1
 */
class TypeEtat
{
    const ACTIF = 1;
    const SUPPRIME = 2;

    /**
     * Libellés des états
     */
    public static function labels(): array
    {
        return [
            self::ACTIF => 'Actif',
            self::SUPPRIME => 'Supprimé',
        ];
    }

    /**
     * Couleurs des badges
     */
    public static function badges(): array
    {
        return [
            self::ACTIF => 'success',
            self::SUPPRIME => 'danger',
        ];
    }

    /**
     * Obtenir le libellé d'un état
     */
    public static function getLabel(int $etat): string
    {
        return self::labels()[$etat] ?? 'Inconnu';
    }

    /**
     * Obtenir la classe du badge
     */
    public static function getBadge(int $etat): string
    {
        return self::badges()[$etat] ?? 'secondary';
    }

    /**
     * Liste pour les selects
     */
    public static function list(): array
    {
        return self::labels();
    }

    /**
     * Vérifier si l'état est actif
     */
    public static function isActive(int $etat): bool
    {
        return $etat === self::ACTIF;
    }

    /**
     * Vérifier si l'état est supprimé
     */
    public static function isDeleted(int $etat): bool
    {
        return $etat === self::SUPPRIME;
    }

    /**
     * États valides
     */
    public static function values(): array
    {
        return [
            self::ACTIF,
            self::SUPPRIME,
        ];
    }

    /**
     * Vérifier si une valeur est valide
     */
    public static function isValid(int $etat): bool
    {
        return in_array($etat, self::values());
    }
}
