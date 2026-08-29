<?php

namespace App\Services;

use App\Models\Document;
use App\Repositories\Interfaces\DocumentInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    protected DocumentInterface $documentRepository;

    public function __construct(DocumentInterface $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    public function getAll(): Collection
    {
        return $this->documentRepository->all();
    }

    public function find(int $id): ?Document
    {
        return $this->documentRepository->find($id);
    }

    public function create(array $data): Document
    {
        return $this->documentRepository->create($data);
    }

    public function update(int $id, array $data): Document
    {
        return $this->documentRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        $document = $this->find($id);
        if ($document && $document->url && Storage::disk('public')->exists($document->url)) {
            Storage::disk('public')->delete($document->url);
        }
        return $this->documentRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->documentRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        $document = $this->find($id);
        if ($document && $document->url && Storage::disk('public')->exists($document->url)) {
            Storage::disk('public')->delete($document->url);
        }
        return $this->documentRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->documentRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->documentRepository->search($query);
    }

    public function getByCategory(int $categorie): Collection
    {
        return $this->documentRepository->findByCategory($categorie);
    }

    public function getByType(string $type): Collection
    {
        return $this->documentRepository->findByType($type);
    }

    public function getStats(): array
    {
        return $this->documentRepository->getStats();
    }

    public function uploadFile($file, string $directory = 'documents'): string
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
