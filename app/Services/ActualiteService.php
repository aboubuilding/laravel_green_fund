<?php

namespace App\Services;

use App\Models\Actualite;
use App\Repositories\Interfaces\ActualiteInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActualiteService
{
    protected ActualiteInterface $actualiteRepository;

    public function __construct(ActualiteInterface $actualiteRepository)
    {
        $this->actualiteRepository = $actualiteRepository;
    }

    public function getAll(): Collection
    {
        return $this->actualiteRepository->all();
    }

    public function getPublished(): Collection
    {
        return $this->actualiteRepository->getPublished();
    }

    public function getDrafts(): Collection
    {
        return $this->actualiteRepository->getDrafts();
    }

    public function getBySlug(string $slug): ?Actualite
    {
        return $this->actualiteRepository->getBySlug($slug);
    }

    public function find(int $id): ?Actualite
    {
        return $this->actualiteRepository->find($id);
    }

    public function create(array $data): Actualite
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['titre']);
        }
        return $this->actualiteRepository->create($data);
    }

    public function update(int $id, array $data): Actualite
    {
        return $this->actualiteRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        $actualite = $this->find($id);
        if ($actualite && $actualite->image && Storage::disk('public')->exists($actualite->image)) {
            Storage::disk('public')->delete($actualite->image);
        }
        return $this->actualiteRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->actualiteRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        $actualite = $this->find($id);
        if ($actualite && $actualite->image && Storage::disk('public')->exists($actualite->image)) {
            Storage::disk('public')->delete($actualite->image);
        }
        return $this->actualiteRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->actualiteRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->actualiteRepository->search($query);
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->actualiteRepository->getRecent($limit);
    }

    public function getStats(): array
    {
        return $this->actualiteRepository->getStats();
    }

    public function publish(int $id): bool
    {
        return $this->actualiteRepository->publish($id);
    }

    public function unpublish(int $id): bool
    {
        return $this->actualiteRepository->unpublish($id);
    }

    public function uploadImage($file, string $directory = 'actualites'): string
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
