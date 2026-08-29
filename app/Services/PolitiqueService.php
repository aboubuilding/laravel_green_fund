<?php

namespace App\Services;

use App\Models\Politique;
use App\Repositories\Interfaces\PolitiqueInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class PolitiqueService
{
    protected PolitiqueInterface $politiqueRepository;

    public function __construct(PolitiqueInterface $politiqueRepository)
    {
        $this->politiqueRepository = $politiqueRepository;
    }

    public function getAll(): Collection
    {
        return $this->politiqueRepository->all();
    }

    public function getPublished(): Collection
    {
        return $this->politiqueRepository->getPublished();
    }

    public function getDrafts(): Collection
    {
        return $this->politiqueRepository->getDrafts();
    }

    public function find(int $id): \Illuminate\Database\Eloquent\Model
    {
        return $this->politiqueRepository->find($id);
    }

    public function create(array $data): Politique
    {
        return $this->politiqueRepository->create($data);
    }

    public function update(int $id, array $data): \Illuminate\Database\Eloquent\Model
    {
        return $this->politiqueRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        $politique = $this->find($id);
        if ($politique && $politique->fichier && Storage::disk('public')->exists($politique->fichier)) {
            Storage::disk('public')->delete($politique->fichier);
        }
        return $this->politiqueRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->politiqueRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        $politique = $this->find($id);
        if ($politique && $politique->fichier && Storage::disk('public')->exists($politique->fichier)) {
            Storage::disk('public')->delete($politique->fichier);
        }
        return $this->politiqueRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->politiqueRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->politiqueRepository->search($query);
    }

    public function getByType(int $typeId): Collection
    {
        return $this->politiqueRepository->getByType($typeId);
    }

    public function getStats(): array
    {
        return $this->politiqueRepository->getStats();
    }

    public function publish(int $id): bool
    {
        return $this->politiqueRepository->publish($id);
    }

    public function unpublish(int $id): bool
    {
        return $this->politiqueRepository->unpublish($id);
    }

    public function uploadFile($file, string $directory = 'politiques'): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $path = $file->storeAs($directory, $filename, 'public');
        return $path;
    }

    public function deleteFile(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return true;
    }
}
