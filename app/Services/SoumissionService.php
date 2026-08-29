<?php

namespace App\Services;

use App\Models\Soumission;
use App\Models\SoumissionHistorique;
use App\Repositories\Interfaces\SoumissionInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class SoumissionService
{
    protected SoumissionInterface $soumissionRepository;

    public function __construct(SoumissionInterface $soumissionRepository)
    {
        $this->soumissionRepository = $soumissionRepository;
    }

    public function getAll(): Collection
    {
        return $this->soumissionRepository->all();
    }

    public function getByStatut(int $statut): Collection
    {
        return $this->soumissionRepository->getByStatut($statut);
    }

    public function getByGuichet(int $guichetId): Collection
    {
        return $this->soumissionRepository->getByGuichet($guichetId);
    }

    public function getByNumero(string $numero): ?Soumission
    {
        return $this->soumissionRepository->getByNumero($numero);
    }

    public function find(int $id): ?Soumission
    {
        return $this->soumissionRepository->find($id);
    }

    public function create(array $data): Soumission
    {
        return $this->soumissionRepository->create($data);
    }

    public function update(int $id, array $data): Soumission
    {
        return $this->soumissionRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->soumissionRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->soumissionRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        return $this->soumissionRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->soumissionRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->soumissionRepository->search($query);
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->soumissionRepository->getRecent($limit);
    }

    public function getStats(): array
    {
        return $this->soumissionRepository->getStats();
    }

    public function getHistoriques(int $soumissionId): Collection
    {
        return $this->soumissionRepository->getHistoriques($soumissionId);
    }

    public function changerStatut(int $soumissionId, int $statut, ?string $commentaire, int $auteurId): bool
    {
        return $this->soumissionRepository->changerStatut($soumissionId, $statut, $commentaire, $auteurId);
    }

    public function uploadDocument($file, string $directory = 'soumissions'): string
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

    public function getMessagesPublic(int $soumissionId): array
    {
        $soumission = $this->find($soumissionId);
        if (!$soumission) {
            return [];
        }

        $historiques = $this->getHistoriques($soumissionId);

        return $historiques->map(function ($h) {
            return [
                'date' => $h->date_action_formatee,
                'statut' => $h->statut_label,
                'commentaire' => $h->commentaire,
            ];
        })->toArray();
    }
}
