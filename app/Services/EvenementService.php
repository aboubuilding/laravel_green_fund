<?php

namespace App\Services;

use App\Models\Evenement;
use App\Repositories\Interfaces\EvenementInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class EvenementService
{
    protected EvenementInterface $evenementRepository;

    public function __construct(EvenementInterface $evenementRepository)
    {
        $this->evenementRepository = $evenementRepository;
    }

    public function getAll(): Collection
    {
        return $this->evenementRepository->all();
    }

    public function getPublished(): Collection
    {
        return $this->evenementRepository->getPublished();
    }

    public function getDrafts(): Collection
    {
        return $this->evenementRepository->getDrafts();
    }

    public function getUpcoming(): Collection
    {
        return $this->evenementRepository->getUpcoming();
    }

    public function getPast(): Collection
    {
        return $this->evenementRepository->getPast();
    }

    public function find(int $id): ?Evenement
    {
        return $this->evenementRepository->find($id);
    }

    public function create(array $data): Evenement
    {
        return $this->evenementRepository->create($data);
    }

    public function update(int $id, array $data): Evenement
    {
        return $this->evenementRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        $evenement = $this->find($id);
        if ($evenement && $evenement->image && Storage::disk('public')->exists($evenement->image)) {
            Storage::disk('public')->delete($evenement->image);
        }
        return $this->evenementRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->evenementRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        $evenement = $this->find($id);
        if ($evenement && $evenement->image && Storage::disk('public')->exists($evenement->image)) {
            Storage::disk('public')->delete($evenement->image);
        }
        return $this->evenementRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->evenementRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->evenementRepository->search($query);
    }

    public function getByType(int $type): Collection
    {
        return $this->evenementRepository->getByType($type);
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->evenementRepository->getRecent($limit);
    }

    public function getStats(): array
    {
        return $this->evenementRepository->getStats();
    }

    public function publish(int $id): bool
    {
        return $this->evenementRepository->publish($id);
    }

    public function unpublish(int $id): bool
    {
        return $this->evenementRepository->unpublish($id);
    }

    public function uploadImage($file, string $directory = 'evenements'): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $path = $file->storeAs($directory, $filename, 'public');
        return $path;
    }

    public function deleteImage(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return true;
    }
}
