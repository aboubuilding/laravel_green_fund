<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserInterface extends BaseRepositoryInterface
{
    /**
     * Trouver un utilisateur par email
     */
    public function findByEmail(string $email): ?User;

    /**
     * Trouver un utilisateur actif par email
     */
    public function findActiveByEmail(string $email): ?User;

    /**
     * Mettre à jour la date de dernière connexion
     */
    public function updateLastLogin(int $id): bool;

    /**
     * Vérifier si un email existe
     */
    public function emailExists(string $email): bool;

    /**
     * Récupérer les administrateurs
     */
    public function getAdmins(): Collection;

    /**
     * Récupérer les utilisateurs par rôle
     */
    public function getByRole(int $roleId): Collection;

    /**
     * Récupérer les utilisateurs récents
     */
    public function getRecent(int $limit = 10): Collection;

    /**
     * Compter les utilisateurs actifs
     */
    public function countActive(): int;

    /**
     * Compter les utilisateurs par rôle
     */
    public function countByRole(int $roleId): int;

    /**
     * Rechercher des utilisateurs
     */
    public function search(string $query): Collection;

    /**
     * Récupérer les utilisateurs inactifs
     */
    public function getInactive(): Collection;

    /**
     * Récupérer les utilisateurs supprimés
     */
    public function getTrashed(): Collection;

    /**
     * Restaurer un utilisateur supprimé
     */
    public function restore(int $id): bool;

    /**
     * Supprimer définitivement un utilisateur
     */
    public function forceDelete(int $id): bool;
}
