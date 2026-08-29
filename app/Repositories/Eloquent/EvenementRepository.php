<?php

namespace App\Repositories\Eloquent;

use App\Models\Evenement;
use App\Repositories\Interfaces\EvenementInterface;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;

class EvenementRepository extends BaseRepository implements EvenementInterface
{
    public function model(): string
    {
        return Evenement::class;
    }

    public function all(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->orderBy('date_evenement', 'asc')
            ->get();
    }

    public function getPublished(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->orderBy('date_evenement', 'asc')
            ->get();
    }

    public function getDrafts(): Collection
    {
        return $this->model
            ->where('etat', '!=', TypeEtat::ACTIF)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getUpcoming(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->whereDate('date_evenement', '>=', now()->toDateString())
            ->orderBy('date_evenement', 'asc')
            ->get();
    }

    public function getPast(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->whereDate('date_evenement', '<', now()->toDateString())
            ->orderBy('date_evenement', 'desc')
            ->get();
    }

    public function getByType(int $type): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('type_evenement', $type)
            ->orderBy('date_evenement', 'asc')
            ->get();
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where(function ($q) use ($query) {
                $q->where('titre', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->orWhere('lieu', 'LIKE', "%{$query}%");
            })
            ->orderBy('date_evenement', 'asc')
            ->get();
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->whereDate('date_evenement', '>=', now()->toDateString())
            ->orderBy('date_evenement', 'asc')
            ->limit($limit)
            ->get();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->where('etat', TypeEtat::ACTIF)->count(),
            'published' => $this->model->where('etat', TypeEtat::ACTIF)->count(),
            'drafts' => $this->model->where('etat', '!=', TypeEtat::ACTIF)->count(),
            'upcoming' => $this->getUpcoming()->count(),
            'past' => $this->getPast()->count(),
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): Evenement
    {
        $data['etat'] = TypeEtat::ACTIF;
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $evenement = $this->find($id);
        if (!$evenement) {
            return false;
        }
        return $evenement->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $evenement = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$evenement) {
            return false;
        }
        return $evenement->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $evenement = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$evenement) {
            return false;
        }
        return $evenement->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }

    public function publish(int $id): bool
    {
        $evenement = $this->find($id);
        if (!$evenement) {
            return false;
        }
        return $evenement->update(['etat' => TypeEtat::ACTIF]);
    }

    public function unpublish(int $id): bool
    {
        $evenement = $this->find($id);
        if (!$evenement) {
            return false;
        }
        return $evenement->update(['etat' => 0]);
    }
}
