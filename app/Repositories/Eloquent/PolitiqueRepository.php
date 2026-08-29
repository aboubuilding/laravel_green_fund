<?php

namespace App\Repositories\Eloquent;

use App\Models\Politique;
use App\Repositories\Interfaces\PolitiqueInterface;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;

class PolitiqueRepository extends BaseRepository implements PolitiqueInterface
{
    public function model(): string
    {
        return Politique::class;
    }

    public function all(): Collection
    {
        return $this->model
            ->orderByRaw('etat DESC')
            ->latest()
            ->get();
    }

    public function getPublished(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->latest()
            ->get();
    }

    public function getDrafts(): Collection
    {
        return $this->model
            ->where('etat', '!=', TypeEtat::ACTIF)
            ->latest()
            ->get();
    }

    public function getByType(int $typeId): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('type_politique_id', $typeId)
            ->latest()
            ->get();
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where(function ($q) use ($query) {
                $q->where('titre', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->latest()
            ->get();
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->count(),
            'published' => $this->model->where('etat', TypeEtat::ACTIF)->count(),
            'drafts' => $this->model->where('etat', '!=', TypeEtat::ACTIF)->count(),
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): Politique
    {
        $data['etat'] = TypeEtat::ACTIF;
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $politique = $this->find($id);
        if (!$politique) {
            return false;
        }
        return $politique->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $politique = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$politique) {
            return false;
        }
        return $politique->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $politique = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$politique) {
            return false;
        }
        return $politique->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }

    public function publish(int $id): bool
    {
        $politique = $this->find($id);
        if (!$politique) {
            return false;
        }
        return $politique->update(['etat' => TypeEtat::ACTIF]);
    }

    public function unpublish(int $id): bool
    {
        $politique = $this->find($id);
        if (!$politique) {
            return false;
        }
        return $politique->update(['etat' => 0]);
    }
}
