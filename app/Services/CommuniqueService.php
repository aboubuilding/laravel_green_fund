<?php

namespace App\Services;

use App\Models\Communique;
use App\Repositories\Interfaces\CommuniqueInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class CommuniqueService
{
    protected CommuniqueInterface $communiqueRepository;

    public function __construct(CommuniqueInterface $communiqueRepository)
    {
        $this->communiqueRepository = $communiqueRepository;
    }

    public function getAll(): Collection
    {
        return $this->communiqueRepository->all();
    }

    public function getPublished(): Collection
    {
        return $this->communiqueRepository->getPublished();
    }

    public function getDrafts(): Collection
    {
        return $this->communiqueRepository->getDrafts();
    }

    public function find(int $id): \Illuminate\Database\Eloquent\Model
    {
        return $this->communiqueRepository->find($id);
    }

    public function create(array $data): Communique
    {
        return $this->communiqueRepository->create($data);
    }

    public function update(int $id, array $data): \Illuminate\Database\Eloquent\Model
    {
        return $this->communiqueRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        $communique = $this->find($id);
        if ($communique && $communique->document_url && Storage::disk('public')->exists($communique->document_url)) {
            Storage::disk('public')->delete($communique->document_url);
        }
        return $this->communiqueRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->communiqueRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        $communique = $this->find($id);
        if ($communique && $communique->document_url && Storage::disk('public')->exists($communique->document_url)) {
            Storage::disk('public')->delete($communique->document_url);
        }
        return $this->communiqueRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->communiqueRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->communiqueRepository->search($query);
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->communiqueRepository->getRecent($limit);
    }

    public function getStats(): array
    {
        return $this->communiqueRepository->getStats();
    }

    public function publish(int $id): bool
    {
        return $this->communiqueRepository->publish($id);
    }

    public function unpublish(int $id): bool
    {
        return $this->communiqueRepository->unpublish($id);
    }

    public function uploadDocument($file, string $directory = 'communiques'): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $path = $file->storeAs($directory, $filename, 'public');
        return $path;
    }

    public function deleteDocument(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return true;
    }
}
