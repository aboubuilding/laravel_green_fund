<?php

namespace App\Repositories\Eloquent;

use App\Models\Plainte;
use App\Repositories\Interfaces\PlainteInterface;
use App\Types\StatutPlainte;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;

class PlainteRepository extends BaseRepository implements PlainteInterface
{
    public function model(): string
    {
        return Plainte::class;
    }

    public function all(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getNouvelles(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut', StatutPlainte::NOUVELLE)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getEnCours(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut', StatutPlainte::EN_COURS)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getResolues(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut', StatutPlainte::RESOLUE)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByStatut(string $statut): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut', $statut)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where(function ($q) use ($query) {
                $q->where('nom', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->orWhere('telephone', 'LIKE', "%{$query}%")
                    ->orWhere('objet', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->where('etat', TypeEtat::ACTIF)->count(),
            'nouvelles' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut', StatutPlainte::NOUVELLE)->count(),
            'en_cours' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut', StatutPlainte::EN_COURS)->count(),
            'resolues' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut', StatutPlainte::RESOLUE)->count(),
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): Plainte
    {
        $data['etat'] = TypeEtat::ACTIF;
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $plainte = $this->find($id);
        if (!$plainte) {
            return false;
        }
        return $plainte->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $plainte = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$plainte) {
            return false;
        }
        return $plainte->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $plainte = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$plainte) {
            return false;
        }
        return $plainte->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }
}
