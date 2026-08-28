<?php

namespace App\Types;

/**
 * Liste des statuts pour les manifestations d'intérêt
 *
 * @author pmazama@gmail.com
 * @copyright HAMZ-Eng 2022
 * @version 1
 */
class StatutManifestation
{
    const NOUVEAU = 1;
    const TRAITE = 2;

    /**
     * Libellés des statuts
     */
    public static function labels(): array
    {
        return [
            self::NOUVEAU => 'Nouveau',
            self::TRAITE => 'Traité',
        ];
    }

    /**
     * Couleurs des badges
     */
    public static function badges(): array
    {
        return [
            self::NOUVEAU => 'primary',
            self::TRAITE => 'success',
        ];
    }

    /**
     * Icônes des statuts
     */
    public static function icons(): array
    {
        return [
            self::NOUVEAU => 'fa-envelope',
            self::TRAITE => 'fa-check-double',
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
     * Vérifier si le statut est nouveau
     */
    public static function isNouveau(int $statut): bool
    {
        return $statut === self::NOUVEAU;
    }

    /**
     * Vérifier si le statut est traité
     */
    public static function isTraite(int $statut): bool
    {
        return $statut === self::TRAITE;
    }

    /**
     * Statuts valides
     */
    public static function values(): array
    {
        return [
            self::NOUVEAU,
            self::TRAITE,
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
            self::NOUVEAU => '#007bff',
            self::TRAITE => '#28a745',
        ];
    }

    /**
     * Obtenir la classe CSS pour l'animation (nouveau messages)
     */
    public static function getAnimationClass(int $statut): string
    {
        return match($statut) {
            self::NOUVEAU => 'animate-pulse',
            self::TRAITE => '',
            default => '',
        };
    }

    /**
     * Obtenir le libellé pour les notifications
     */
    public static function getNotificationLabel(int $statut): string
    {
        return match($statut) {
            self::NOUVEAU => 'Nouvelle manifestation d\'intérêt',
            self::TRAITE => 'Manifestation traitée',
            default => 'Statut mis à jour',
        };
    }
}
