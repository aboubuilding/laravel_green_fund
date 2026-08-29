<?php

namespace App\Repositories\Eloquent;

use App\Models\Manifestation;
use App\Repositories\Interfaces\ManifestationInterface;
use App\Types\StatutManifestation;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;

class ManifestationRepository extends BaseRepository implements ManifestationInterface
{
    public function model(): string
    {
        return Manifestation::class;
    }

    public function all(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->with(['guichet', 'domaineInteret'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getNouvelles(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut_manifestation', StatutManifestation::NOUVEAU)
            ->with(['guichet', 'domaineInteret'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getTraitees(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut_manifestation', StatutManifestation::TRAITE)
            ->with(['guichet', 'domaineInteret'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByStatut(int $statut): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut_manifestation', $statut)
            ->with(['guichet', 'domaineInteret'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByGuichet(int $guichetId): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('guichet_id', $guichetId)
            ->with(['guichet', 'domaineInteret'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByDomaine(int $domaineId): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('domaine_interet_id', $domaineId)
            ->with(['guichet', 'domaineInteret'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where(function ($q) use ($query) {
                $q->where('nom', 'LIKE', "%{$query}%")
                    ->orWhere('prenom', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->orWhere('telephone', 'LIKE', "%{$query}%")
                    ->orWhere('message', 'LIKE', "%{$query}%");
            })
            ->with(['guichet', 'domaineInteret'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->with(['guichet', 'domaineInteret'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->where('etat', TypeEtat::ACTIF)->count(),
            'nouvelles' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut_manifestation', StatutManifestation::NOUVEAU)->count(),
            'traitees' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut_manifestation', StatutManifestation::TRAITE)->count(),
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): Manifestation
    {
        $data['etat'] = TypeEtat::ACTIF;
        $data['statut_manifestation'] = StatutManifestation::NOUVEAU;
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $manifestation = $this->find($id);
        if (!$manifestation) {
            return false;
        }
        return $manifestation->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $manifestation = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$manifestation) {
            return false;
        }
        return $manifestation->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $manifestation = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$manifestation) {
            return false;
        }
        return $manifestation->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }

    public function traiter(int $id): bool
    {
        $manifestation = $this->find($id);
        if (!$manifestation) {
            return false;
        }
        return $manifestation->update(['statut_manifestation' => StatutManifestation::TRAITE]);
    }
}
