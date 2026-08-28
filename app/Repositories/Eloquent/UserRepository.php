<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserInterface;
use App\Types\Role;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserInterface
{
    /**
     * {@inheritdoc}
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data): User
    {
        if (isset($data['mot_de_passe'])) {
            $data['mot_de_passe'] = Hash::make($data['mot_de_passe']);
        }
        $data['etat'] = TypeEtat::ACTIF;
        return $this->model->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $data): User
    {
        $user = $this->find($id);
        if (!$user) {
            throw new \Exception('User not found');
        }

        if (isset($data['mot_de_passe'])) {
            $data['mot_de_passe'] = Hash::make($data['mot_de_passe']);
        }

        $user->update($data);
        return $user->fresh();
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): bool
    {
        $user = $this->find($id);
        if (!$user) {
            return false;
        }
        return $user->update(['etat' => TypeEtat::SUPPRIME]);
    }

    /**
     * {@inheritdoc}
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function findActiveByEmail(string $email): ?User
    {
        return $this->model
            ->where('email', $email)
            ->where('etat', TypeEtat::ACTIF)
            ->where('est_actif', true)
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function updateLastLogin(int $id): bool
    {
        $user = $this->find($id);
        if (!$user) {
            return false;
        }
        return $user->update(['derniere_connexion_le' => now()]);
    }

    /**
     * {@inheritdoc}
     */
    public function emailExists(string $email): bool
    {
        return $this->model->where('email', $email)->exists();
    }

    /**
     * {@inheritdoc}
     */
    public function getAdmins(): Collection
    {
        return $this->model
            ->where('role_id', Role::ADMIN)
            ->where('etat', TypeEtat::ACTIF)
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getByRole(int $roleId): Collection
    {
        return $this->model
            ->where('role_id', $roleId)
            ->where('etat', TypeEtat::ACTIF)
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getRecent(int $limit = 10): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function countActive(): int
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('est_actif', true)
            ->count();
    }

    /**
     * {@inheritdoc}
     */
    public function countByRole(int $roleId): int
    {
        return $this->model
            ->where('role_id', $roleId)
            ->where('etat', TypeEtat::ACTIF)
            ->count();
    }

    /**
     * {@inheritdoc}
     */
    public function search(string $query): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where(function ($q) use ($query) {
                $q->where('nom', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->orWhere('telephone', 'LIKE', "%{$query}%");
            })
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getInactive(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('est_actif', false)
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function restore(int $id): bool
    {
        $user = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$user) {
            return false;
        }
        return $user->update(['etat' => TypeEtat::ACTIF]);
    }

    /**
     * {@inheritdoc}
     */
    public function forceDelete(int $id): bool
    {
        $user = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$user) {
            return false;
        }
        return $user->delete();
    }

    /**
     * Récupérer les statistiques des utilisateurs
     */
    public function getStats(): array
    {
        return [
            'total' => $this->countActive(),
            'admins' => $this->countByRole(Role::ADMIN),
            'users' => $this->countByRole(Role::USER),
            'inactive' => $this->getInactive()->count(),
            'trashed' => $this->getTrashed()->count(),
        ];
    }
}
