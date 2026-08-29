<?php

namespace App\Services;

use App\Models\Plainte;
use App\Repositories\Interfaces\PlainteInterface;
use App\Types\StatutPlainte;
use Illuminate\Support\Collection;

class PlainteService
{
    protected PlainteInterface $plainteRepository;

    public function __construct(PlainteInterface $plainteRepository)
    {
        $this->plainteRepository = $plainteRepository;
    }

    public function getAll(): Collection
    {
        return $this->plainteRepository->all();
    }

    public function getNouvelles(): Collection
    {
        return $this->plainteRepository->getNouvelles();
    }

    public function getEnCours(): Collection
    {
        return $this->plainteRepository->getEnCours();
    }

    public function getResolues(): Collection
    {
        return $this->plainteRepository->getResolues();
    }

    public function getByStatut(string $statut): Collection
    {
        return $this->plainteRepository->getByStatut($statut);
    }

    public function find(int $id): \Illuminate\Database\Eloquent\Model
    {
        return $this->plainteRepository->find($id);
    }

    public function create(array $data): Plainte
    {
        return $this->plainteRepository->create($data);
    }

    public function update(int $id, array $data): Plainte
    {
        return $this->plainteRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->plainteRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->plainteRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        return $this->plainteRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->plainteRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->plainteRepository->search($query);
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->plainteRepository->getRecent($limit);
    }

    public function getStats(): array
    {
        return $this->plainteRepository->getStats();
    }

    public function changerStatut(int $id, string $statut): bool
    {
        $plainte = $this->find($id);
        if (!$plainte) {
            return false;
        }
        return $plainte->update(['statut' => $statut]);
    }

    public function repondre(int $id, string $reponse): bool
    {
        $plainte = $this->find($id);
        if (!$plainte) {
            return false;
        }
        return $plainte->update(['reponse' => $reponse]);
    }

    public function cloturer(int $id): bool
    {
        return $this->changerStatut($id, StatutPlainte::RESOLUE);
    }

    public function exportCsv(): string
    {
        $plaintes = $this->getAll();
        $filename = 'plaintes_' . date('Y-m-d_H-i-s') . '.csv';

        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['ID', 'Nom', 'Email', 'Téléphone', 'Objet', 'Description', 'Statut', 'Réponse', 'Date']);

        foreach ($plaintes as $plainte) {
            fputcsv($handle, [
                $plainte->id,
                $plainte->nom,
                $plainte->email,
                $plainte->telephone,
                $plainte->objet,
                $plainte->description,
                $plainte->statut_label,
                $plainte->reponse,
                $plainte->date_formatee,
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return $content;
    }
}
