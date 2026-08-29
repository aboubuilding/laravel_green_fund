<?php

namespace App\Services;

use App\Models\Grief;
use App\Repositories\Interfaces\GriefInterface;
use App\Types\StatutGrief;
use Illuminate\Support\Collection;

class GriefService
{
    protected GriefInterface $griefRepository;

    public function __construct(GriefInterface $griefRepository)
    {
        $this->griefRepository = $griefRepository;
    }

    public function getAll(): Collection
    {
        return $this->griefRepository->all();
    }

    public function getNouveaux(): Collection
    {
        return $this->griefRepository->getNouveaux();
    }

    public function getEnCours(): Collection
    {
        return $this->griefRepository->getEnCours();
    }

    public function getResolus(): Collection
    {
        return $this->griefRepository->getResolus();
    }

    public function getByStatut(string $statut): Collection
    {
        return $this->griefRepository->getByStatut($statut);
    }

    public function getByProjet(int $projetId): Collection
    {
        return $this->griefRepository->getByProjet($projetId);
    }

    public function find(int $id): ?Grief
    {
        return $this->griefRepository->find($id);
    }

    public function create(array $data): Grief
    {
        return $this->griefRepository->create($data);
    }

    public function update(int $id, array $data): Grief
    {
        return $this->griefRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->griefRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->griefRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        return $this->griefRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->griefRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->griefRepository->search($query);
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->griefRepository->getRecent($limit);
    }

    public function getStats(): array
    {
        return $this->griefRepository->getStats();
    }

    public function changerStatut(int $id, string $statut): bool
    {
        $grief = $this->find($id);
        if (!$grief) {
            return false;
        }
        return $grief->update(['statut' => $statut]);
    }

    public function repondre(int $id, string $reponse): bool
    {
        $grief = $this->find($id);
        if (!$grief) {
            return false;
        }
        return $grief->update(['reponse' => $reponse]);
    }

    public function cloturer(int $id): bool
    {
        return $this->changerStatut($id, StatutGrief::RESOLU);
    }

    public function exportCsv(): string
    {
        $griefs = $this->getAll();
        $filename = 'griefs_' . date('Y-m-d_H-i-s') . '.csv';

        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['ID', 'Nom', 'Email', 'Téléphone', 'Projet', 'Description', 'Statut', 'Réponse', 'Date']);

        foreach ($griefs as $grief) {
            fputcsv($handle, [
                $grief->id,
                $grief->nom,
                $grief->email,
                $grief->telephone,
                $grief->nom_projet,
                $grief->description,
                $grief->statut_label,
                $grief->reponse,
                $grief->date_formatee,
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return $content;
    }
}
