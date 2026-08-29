<?php

namespace App\Repositories\Eloquent;

use App\Models\Projet;
use App\Repositories\Interfaces\ProjetInterface;
use App\Types\StatutProjet;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;

class ProjetRepository extends BaseRepository implements ProjetInterface
{
    public function model(): string
    {
        return Projet::class;
    }

    public function all(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->with(['region', 'prefecture', 'commune', 'typeProjet'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getActive(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->with(['region', 'prefecture', 'commune', 'typeProjet'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getBySlug(string $slug): ?Projet
    {
        return $this->model
            ->where('slug', $slug)
            ->where('etat', TypeEtat::ACTIF)
            ->with(['region', 'prefecture', 'commune', 'typeProjet'])
            ->first();
    }

    public function getByStatut(int $statut): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut_projet', $statut)
            ->with(['region', 'prefecture', 'commune', 'typeProjet'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByType(int $typeId): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('type_projet_id', $typeId)
            ->with(['region', 'prefecture', 'commune', 'typeProjet'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByRegion(int $regionId): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('region_id', $regionId)
            ->with(['region', 'prefecture', 'commune', 'typeProjet'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where(function ($q) use ($query) {
                $q->where('titre', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->with(['region', 'prefecture', 'commune', 'typeProjet'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->with(['region', 'prefecture', 'commune', 'typeProjet'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getStats(): array
    {
        $total = $this->model->where('etat', TypeEtat::ACTIF)->count();

        return [
            'total' => $total,
            'en_cours' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut_projet', StatutProjet::EN_COURS)->count(),
            'termines' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut_projet', StatutProjet::TERMINE)->count(),
            'a_venir' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut_projet', StatutProjet::A_VENIR)->count(),
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): Projet
    {
        $data['etat'] = TypeEtat::ACTIF;
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $projet = $this->find($id);
        if (!$projet) {
            return false;
        }
        return $projet->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $projet = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$projet) {
            return false;
        }
        return $projet->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $projet = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$projet) {
            return false;
        }
        return $projet->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }
}
