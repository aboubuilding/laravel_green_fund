<?php

namespace App\Repositories\Eloquent;

use App\Models\Communique;
use App\Repositories\Interfaces\CommuniqueInterface;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;

class CommuniqueRepository extends BaseRepository implements CommuniqueInterface
{
    public function model(): string
    {
        return Communique::class;
    }

    public function all(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->orderBy('date_publication', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getPublished(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->orderBy('date_publication', 'desc')
            ->get();
    }

    public function getDrafts(): Collection
    {
        return $this->model
            ->where('etat', '!=', TypeEtat::ACTIF)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where(function ($q) use ($query) {
                $q->where('titre', 'LIKE', "%{$query}%")
                    ->orWhere('resume', 'LIKE', "%{$query}%");
            })
            ->orderBy('date_publication', 'desc')
            ->get();
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->orderBy('date_publication', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->where('etat', TypeEtat::ACTIF)->count(),
            'published' => $this->model->where('etat', TypeEtat::ACTIF)->count(),
            'drafts' => $this->model->where('etat', '!=', TypeEtat::ACTIF)->count(),
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): Communique
    {
        $data['etat'] = TypeEtat::ACTIF;
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $communique = $this->find($id);
        if (!$communique) {
            return false;
        }
        return $communique->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $communique = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$communique) {
            return false;
        }
        return $communique->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $communique = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$communique) {
            return false;
        }
        return $communique->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }

    public function publish(int $id): bool
    {
        $communique = $this->find($id);
        if (!$communique) {
            return false;
        }
        return $communique->update(['etat' => TypeEtat::ACTIF]);
    }

    public function unpublish(int $id): bool
    {
        $communique = $this->find($id);
        if (!$communique) {
            return false;
        }
        return $communique->update(['etat' => 0]);
    }
}
