<?php

namespace App\Services;

use App\Models\Facilite;
use App\Repositories\Interfaces\FaciliteInterface;
use Illuminate\Support\Collection;

class FaciliteService
{
    protected FaciliteInterface $faciliteRepository;

    public function __construct(FaciliteInterface $faciliteRepository)
    {
        $this->faciliteRepository = $faciliteRepository;
    }

    public function getAll(): Collection
    {
        return $this->faciliteRepository->all();
    }

    public function getActive(): Collection
    {
        return $this->faciliteRepository->getActive();
    }

    public function getBySlug(string $slug): ?Facilite
    {
        return $this->faciliteRepository->getBySlug($slug);
    }

    public function find(int $id): \Illuminate\Database\Eloquent\Model
    {
        return $this->faciliteRepository->find($id);
    }

    public function create(array $data): Facilite
    {
        return $this->faciliteRepository->create($data);
    }

    public function update(int $id, array $data): \Illuminate\Database\Eloquent\Model
    {
        return $this->faciliteRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->faciliteRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->faciliteRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        return $this->faciliteRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->faciliteRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->faciliteRepository->search($query);
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->faciliteRepository->getRecent($limit);
    }

    public function getStats(): array
    {
        return $this->faciliteRepository->getStats();
    }

    public function getProjects(int $id): Collection
    {
        return $this->faciliteRepository->getProjects($id);
    }

    public function attachProject(int $faciliteId, int $projetId): bool
    {
        return $this->faciliteRepository->attachProject($faciliteId, $projetId);
    }

    public function detachProject(int $faciliteId, int $projetId): bool
    {
        return $this->faciliteRepository->detachProject($faciliteId, $projetId);
    }

    public function getChiffres(int $id): Collection
    {
        return $this->faciliteRepository->getChiffres($id);
    }

    public function addChiffre(int $faciliteId, array $data): \App\Models\FaciliteChiffre
    {
        return $this->faciliteRepository->addChiffre($faciliteId, $data);
    }

    public function updateChiffre(int $chiffreId, array $data): \App\Models\FaciliteChiffre
    {
        return $this->faciliteRepository->updateChiffre($chiffreId, $data);
    }

    public function deleteChiffre(int $chiffreId): bool
    {
        return $this->faciliteRepository->deleteChiffre($chiffreId);
    }
}
