<?php

namespace App\Repositories\Eloquent;

use App\Models\Actualite;
use App\Repositories\Interfaces\ActualiteInterface;
use App\Types\StatutActualite;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ActualiteRepository extends BaseRepository implements ActualiteInterface
{
    public function model(): string
    {
        return Actualite::class;
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
            ->where('statut_actualite', StatutActualite::PUBLIE)
            ->where('date_publication', '<=', now())
            ->orderBy('date_publication', 'desc')
            ->get();
    }

    public function getDrafts(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where(function ($q) {
                $q->where('statut_actualite', StatutActualite::BROUILLON)
                    ->orWhere('date_publication', '>', now());
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getBySlug(string $slug): ?Actualite
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut_actualite', StatutActualite::PUBLIE)
            ->where('slug', $slug)
            ->first();
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where(function ($q) use ($query) {
                $q->where('titre', 'LIKE', "%{$query}%")
                    ->orWhere('contenu', 'LIKE', "%{$query}%")
                    ->orWhere('extrait', 'LIKE', "%{$query}%");
            })
            ->orderBy('date_publication', 'desc')
            ->get();
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut_actualite', StatutActualite::PUBLIE)
            ->where('date_publication', '<=', now())
            ->orderBy('date_publication', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->where('etat', TypeEtat::ACTIF)->count(),
            'published' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut_actualite', StatutActualite::PUBLIE)->count(),
            'drafts' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut_actualite', StatutActualite::BROUILLON)->count(),
            'scheduled' => $this->model->where('etat', TypeEtat::ACTIF)->where('date_publication', '>', now())->count(),
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): Actualite
    {
        $data['etat'] = TypeEtat::ACTIF;
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $actualite = $this->find($id);
        if (!$actualite) {
            return false;
        }
        return $actualite->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $actualite = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$actualite) {
            return false;
        }
        return $actualite->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $actualite = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$actualite) {
            return false;
        }
        return $actualite->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }

    public function publish(int $id): bool
    {
        $actualite = $this->find($id);
        if (!$actualite) {
            return false;
        }
        return $actualite->update([
            'statut_actualite' => StatutActualite::PUBLIE,
            'date_publication' => $actualite->date_publication ?? now(),
        ]);
    }

    public function unpublish(int $id): bool
    {
        $actualite = $this->find($id);
        if (!$actualite) {
            return false;
        }
        return $actualite->update(['statut_actualite' => StatutActualite::BROUILLON]);
    }
}
