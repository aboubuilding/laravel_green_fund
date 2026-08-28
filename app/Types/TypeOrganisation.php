<?php

namespace App\Types;

/**
 * Liste des types d'organisations
 *
 * @author pmazama@gmail.com
 * @copyright HAMZ-Eng 2022
 * @version 1
 */
class TypeOrganisation
{
    const ASSOCIATION_ONG = 1;
    const ENTREPRISE_PRIVEE = 2;
    const COLLECTIVITE_LOCALE = 3;
    const INSTITUTION_PUBLIQUE = 4;
    const GROUPEMENT_PRODUCTION = 5;

    /**
     * Libellés des types d'organisations
     */
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

    /**
     * Couleurs des badges
     */
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

    /**
     * Icônes des types d'organisations
     */
    public static function icons(): array
    {
        return [
            self::ASSOCIATION_ONG => 'fa-hand-holding-heart',
            self::ENTREPRISE_PRIVEE => 'fa-building',
            self::COLLECTIVITE_LOCALE => 'fa-city',
            self::INSTITUTION_PUBLIQUE => 'fa-university',
            self::GROUPEMENT_PRODUCTION => 'fa-users',
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
     * Vérifier si c'est une association/ONG
     */
    public static function isAssociationOng(int $type): bool
    {
        return $type === self::ASSOCIATION_ONG;
    }

    /**
     * Vérifier si c'est une entreprise privée
     */
    public static function isEntreprisePrivee(int $type): bool
    {
        return $type === self::ENTREPRISE_PRIVEE;
    }

    /**
     * Vérifier si c'est une collectivité locale
     */
    public static function isCollectiviteLocale(int $type): bool
    {
        return $type === self::COLLECTIVITE_LOCALE;
    }

    /**
     * Vérifier si c'est une institution publique
     */
    public static function isInstitutionPublique(int $type): bool
    {
        return $type === self::INSTITUTION_PUBLIQUE;
    }

    /**
     * Vérifier si c'est un groupement de production
     */
    public static function isGroupementProduction(int $type): bool
    {
        return $type === self::GROUPEMENT_PRODUCTION;
    }

    /**
     * Types valides
     */
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
            self::ASSOCIATION_ONG => '#007bff',
            self::ENTREPRISE_PRIVEE => '#28a745',
            self::COLLECTIVITE_LOCALE => '#ffc107',
            self::INSTITUTION_PUBLIQUE => '#dc3545',
            self::GROUPEMENT_PRODUCTION => '#17a2b8',
        ];
    }

    /**
     * Obtenir la catégorie (public/privé)
     */
    public static function getCategory(int $type): string
    {
        return match($type) {
            self::ASSOCIATION_ONG, self::GROUPEMENT_PRODUCTION => 'Société civile',
            self::ENTREPRISE_PRIVEE => 'Privé',
            self::COLLECTIVITE_LOCALE, self::INSTITUTION_PUBLIQUE => 'Public',
            default => 'Non classé',
        };
    }

    /**
     * Obtenir la description du type
     */
    public static function getDescription(int $type): string
    {
        return match($type) {
            self::ASSOCIATION_ONG => 'Organisation à but non lucratif',
            self::ENTREPRISE_PRIVEE => 'Société commerciale privée',
            self::COLLECTIVITE_LOCALE => 'Commune, préfecture, région',
            self::INSTITUTION_PUBLIQUE => 'Ministère, agence gouvernementale',
            self::GROUPEMENT_PRODUCTION => 'Coopérative, groupement d\'intérêt économique',
            default => '',
        };
    }

    /**
     * Vérifier si le type est éligible aux subventions
     */
    public static function isEligibleSubvention(int $type): bool
    {
        return in_array($type, [
            self::ASSOCIATION_ONG,
            self::GROUPEMENT_PRODUCTION,
            self::COLLECTIVITE_LOCALE,
        ]);
    }
}
