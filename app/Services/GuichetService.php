<?php

namespace App\Services;

use App\Models\Guichet;
use App\Repositories\Interfaces\GuichetInterface;
use Illuminate\Support\Collection;

class GuichetService
{
    protected GuichetInterface $guichetRepository;

    public function __construct(GuichetInterface $guichetRepository)
    {
        $this->guichetRepository = $guichetRepository;
    }

    public function getAll(): Collection
    {
        return $this->guichetRepository->all();
    }

    public function getActive(): Collection
    {
        return $this->guichetRepository->getActive();
    }

    public function getBySlug(string $slug): ?Guichet
    {
        return $this->guichetRepository->getBySlug($slug);
    }

    public function find(int $id): \Illuminate\Database\Eloquent\Model
    {
        return $this->guichetRepository->find($id);
    }

    public function create(array $data): Guichet
    {
        return $this->guichetRepository->create($data);
    }

    public function update(int $id, array $data): \Illuminate\Database\Eloquent\Model
    {
        return $this->guichetRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->guichetRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->guichetRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        return $this->guichetRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->guichetRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->guichetRepository->search($query);
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->guichetRepository->getRecent($limit);
    }

    public function getStats(): array
    {
        return $this->guichetRepository->getStats();
    }

    public function getProjects(int $id): Collection
    {
        return $this->guichetRepository->getProjects($id);
    }

    public function attachProject(int $guichetId, int $projetId): bool
    {
        return $this->guichetRepository->attachProject($guichetId, $projetId);
    }

    public function detachProject(int $guichetId, int $projetId): bool
    {
        return $this->guichetRepository->detachProject($guichetId, $projetId);
    }

    public function getChiffres(int $id): Collection
    {
        return $this->guichetRepository->getChiffres($id);
    }

    public function addChiffre(int $guichetId, array $data): \App\Models\GuichetChiffre
    {
        return $this->guichetRepository->addChiffre($guichetId, $data);
    }

    public function updateChiffre(int $chiffreId, array $data): \App\Models\GuichetChiffre
    {
        return $this->guichetRepository->updateChiffre($chiffreId, $data);
    }

    public function deleteChiffre(int $chiffreId): bool
    {
        return $this->guichetRepository->deleteChiffre($chiffreId);
    }
}
