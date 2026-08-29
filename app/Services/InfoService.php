<?php

namespace App\Services;

use App\Models\Info;
use App\Repositories\Interfaces\InfoInterface;
use Illuminate\Support\Collection;

class InfoService
{
    protected InfoInterface $infoRepository;

    public function __construct(InfoInterface $infoRepository)
    {
        $this->infoRepository = $infoRepository;
    }

    public function getAll(): Collection
    {
        return $this->infoRepository->all();
    }

    public function getActive(): Collection
    {
        return $this->infoRepository->getActive();
    }

    public function getInactive(): Collection
    {
        return $this->infoRepository->getInactive();
    }

    public function find(int $id): ?Info
    {
        return $this->infoRepository->find($id);
    }

    public function create(array $data): Info
    {
        return $this->infoRepository->create($data);
    }

    public function update(int $id, array $data): Info
    {
        return $this->infoRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->infoRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->infoRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        return $this->infoRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->infoRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->infoRepository->search($query);
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->infoRepository->getRecent($limit);
    }

    public function getStats(): array
    {
        return $this->infoRepository->getStats();
    }

    public function toggleStatus(int $id): bool
    {
        return $this->infoRepository->toggleStatus($id);
    }
}
