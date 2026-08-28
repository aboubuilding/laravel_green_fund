<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserInterface;
use App\Types\Role;
use Illuminate\Support\Collection;

class UserService
{
    protected UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll(): Collection
    {
        return $this->userRepository->all();
    }

    public function find(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function create(array $data): User
    {
        return $this->userRepository->create($data);
    }

    public function update(int $id, array $data): User
    {
        return $this->userRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->userRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->userRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        return $this->userRepository->forceDelete($id);
    }

    public function search(string $query): Collection
    {
        return $this->userRepository->search($query);
    }

    public function getAdmins(): Collection
    {
        return $this->userRepository->getAdmins();
    }

    public function getByRole(int $roleId): Collection
    {
        return $this->userRepository->getByRole($roleId);
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->userRepository->getRecent($limit);
    }

    public function toggleStatus(int $id): bool
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return false;
        }
        return $user->update(['est_actif' => !$user->est_actif]);
    }

    public function getStats(): array
    {
        return $this->userRepository->getStats();
    }
}
