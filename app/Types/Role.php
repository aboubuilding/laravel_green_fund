<?php

namespace App\Types;

/**
 * Liste des rôles utilisateur
 *
 * @author aboukadani@gmail.com
 * @copyright ABOU-DEV  2026
 * @version 1
 */
class Role
{
    const USER = 1;
    const ADMIN = 2;

    /**
     * Libellés des rôles
     */
    public static function labels(): array
    {
        return [
            self::USER => 'Utilisateur',
            self::ADMIN => 'Administrateur',
        ];
    }

    /**
     * Couleurs des badges
     */
    public static function badges(): array
    {
        return [
            self::USER => 'primary',
            self::ADMIN => 'danger',
        ];
    }

    /**
     * Icônes des rôles
     */
    public static function icons(): array
    {
        return [
            self::USER => 'fa-user',
            self::ADMIN => 'fa-user-shield',
        ];
    }

    /**
     * Obtenir le libellé d'un rôle
     */
    public static function getLabel(int $role): string
    {
        return self::labels()[$role] ?? 'Inconnu';
    }

    /**
     * Obtenir la classe du badge
     */
    public static function getBadge(int $role): string
    {
        return self::badges()[$role] ?? 'secondary';
    }

    /**
     * Obtenir l'icône d'un rôle
     */
    public static function getIcon(int $role): string
    {
        return self::icons()[$role] ?? 'fa-user';
    }

    /**
     * Liste pour les selects
     */
    public static function list(): array
    {
        return self::labels();
    }

    /**
     * Vérifier si le rôle est utilisateur
     */
    public static function isUser(int $role): bool
    {
        return $role === self::USER;
    }

    /**
     * Vérifier si le rôle est administrateur
     */
    public static function isAdmin(int $role): bool
    {
        return $role === self::ADMIN;
    }

    /**
     * Rôles valides
     */
    public static function values(): array
    {
        return [
            self::USER,
            self::ADMIN,
        ];
    }

    /**
     * Vérifier si une valeur est valide
     */
    public static function isValid(int $role): bool
    {
        return in_array($role, self::values());
    }
}
