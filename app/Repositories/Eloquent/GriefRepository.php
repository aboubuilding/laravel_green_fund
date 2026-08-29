<?php

namespace App\Repositories\Eloquent;

use App\Models\Grief;
use App\Repositories\Interfaces\GriefInterface;
use App\Types\StatutGrief;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;

class GriefRepository extends BaseRepository implements GriefInterface
{
    public function model(): string
    {
        return Grief::class;
    }

    public function all(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getNouveaux(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut', StatutGrief::NOUVEAU)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getEnCours(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut', StatutGrief::EN_COURS)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getResolus(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut', StatutGrief::RESOLU)
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

    public function getByProjet(int $projetId): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('projet_concerne_id', $projetId)
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
            'nouveaux' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut', StatutGrief::NOUVEAU)->count(),
            'en_cours' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut', StatutGrief::EN_COURS)->count(),
            'resolus' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut', StatutGrief::RESOLU)->count(),
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): Grief
    {
        $data['etat'] = TypeEtat::ACTIF;
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $grief = $this->find($id);
        if (!$grief) {
            return false;
        }
        return $grief->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $grief = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$grief) {
            return false;
        }
        return $grief->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $grief = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$grief) {
            return false;
        }
        return $grief->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }
}
