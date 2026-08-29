<?php

namespace App\Repositories\Eloquent;

use App\Models\Info;
use App\Repositories\Interfaces\InfoInterface;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;

class InfoRepository extends BaseRepository implements InfoInterface
{
    public function model(): string
    {
        return Info::class;
    }

    public function all(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->orderBy('date', 'desc')
            ->latest()
            ->get();
    }

    public function getActive(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->orderBy('date', 'desc')
            ->latest()
            ->get();
    }

    public function getInactive(): Collection
    {
        return $this->model
            ->where('etat', '!=', TypeEtat::ACTIF)
            ->orderBy('date', 'desc')
            ->get();
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where(function ($q) use ($query) {
                $q->where('titre', 'LIKE', "%{$query}%")
                    ->orWhere('contenu', 'LIKE', "%{$query}%");
            })
            ->orderBy('date', 'desc')
            ->get();
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->orderBy('date', 'desc')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->where('etat', TypeEtat::ACTIF)->count(),
            'active' => $this->model->where('etat', TypeEtat::ACTIF)->count(),
            'inactive' => $this->model->where('etat', '!=', TypeEtat::ACTIF)->count(),
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): Info
    {
        $data['etat'] = TypeEtat::ACTIF;
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $info = $this->find($id);
        if (!$info) {
            return false;
        }
        return $info->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $info = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$info) {
            return false;
        }
        return $info->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $info = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$info) {
            return false;
        }
        return $info->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }

    public function toggleStatus(int $id): bool
    {
        $info = $this->find($id);
        if (!$info) {
            return false;
        }
        $newEtat = $info->etat === TypeEtat::ACTIF ? TypeEtat::SUPPRIME : TypeEtat::ACTIF;
        return $info->update(['etat' => $newEtat]);
    }
}
