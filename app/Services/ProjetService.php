<?php

namespace App\Services;

use App\Models\Projet;
use App\Repositories\Interfaces\ProjetInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ProjetService
{
    protected ProjetInterface $projetRepository;

    public function __construct(ProjetInterface $projetRepository)
    {
        $this->projetRepository = $projetRepository;
    }

    public function getAll(): Collection
    {
        return $this->projetRepository->all();
    }

    public function getActive(): Collection
    {
        return $this->projetRepository->getActive();
    }

    public function getBySlug(string $slug): ?Projet
    {
        return $this->projetRepository->getBySlug($slug);
    }

    public function getByStatut(int $statut): Collection
    {
        return $this->projetRepository->getByStatut($statut);
    }

    public function getByType(int $typeId): Collection
    {
        return $this->projetRepository->getByType($typeId);
    }

    public function getByRegion(int $regionId): Collection
    {
        return $this->projetRepository->getByRegion($regionId);
    }

    public function find(int $id): ?Projet
    {
        return $this->projetRepository->find($id);
    }

    public function create(array $data): Projet
    {
        return $this->projetRepository->create($data);
    }

    public function update(int $id, array $data): Projet
    {
        return $this->projetRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        $projet = $this->find($id);
        if ($projet && $projet->image && Storage::disk('public')->exists($projet->image)) {
            Storage::disk('public')->delete($projet->image);
        }
        return $this->projetRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->projetRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        $projet = $this->find($id);
        if ($projet && $projet->image && Storage::disk('public')->exists($projet->image)) {
            Storage::disk('public')->delete($projet->image);
        }
        return $this->projetRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->projetRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->projetRepository->search($query);
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->projetRepository->getRecent($limit);
    }

    public function getStats(): array
    {
        return $this->projetRepository->getStats();
    }

    public function uploadImage($file, string $directory = 'projets'): string
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
