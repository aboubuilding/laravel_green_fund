<?php

namespace App\Repositories\Eloquent;

use App\Models\Guichet;
use App\Models\GuichetChiffre;
use App\Models\GuichetProjet;
use App\Repositories\Interfaces\GuichetInterface;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;

class GuichetRepository extends BaseRepository implements GuichetInterface
{
    public function model(): string
    {
        return Guichet::class;
    }

    public function all(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->orderBy('nom')
            ->get();
    }

    public function getActive(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->orderBy('nom')
            ->get();
    }

    public function getBySlug(string $slug): ?Guichet
    {
        return $this->model
            ->where('slug', $slug)
            ->where('etat', TypeEtat::ACTIF)
            ->first();
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where(function ($q) use ($query) {
                $q->where('nom', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->orderBy('nom')
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
        $active = $this->model->where('etat', TypeEtat::ACTIF)->count();
        $totalProjets = GuichetProjet::where('etat', TypeEtat::ACTIF)->count();

        return [
            'total' => $this->model->count(),
            'active' => $active,
            'inactive' => $this->model->where('etat', '!=', TypeEtat::ACTIF)->count(),
            'total_projets' => $totalProjets,
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): Guichet
    {
        $data['etat'] = TypeEtat::ACTIF;
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $guichet = $this->find($id);
        if (!$guichet) {
            return false;
        }

        // Détacher tous les projets
        GuichetProjet::where('guichet_id', $id)->update(['etat' => TypeEtat::SUPPRIME]);
        GuichetChiffre::where('guichet_id', $id)->update(['etat' => TypeEtat::SUPPRIME]);

        return $guichet->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $guichet = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$guichet) {
            return false;
        }

        GuichetProjet::where('guichet_id', $id)->update(['etat' => TypeEtat::ACTIF]);
        GuichetChiffre::where('guichet_id', $id)->update(['etat' => TypeEtat::ACTIF]);

        return $guichet->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $guichet = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$guichet) {
            return false;
        }

        GuichetProjet::where('guichet_id', $id)->delete();
        GuichetChiffre::where('guichet_id', $id)->delete();

        return $guichet->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }

    public function getProjects(int $id): Collection
    {
        return GuichetProjet::where('guichet_id', $id)
            ->where('etat', TypeEtat::ACTIF)
            ->with('projet')
            ->get()
            ->pluck('projet');
    }

    public function attachProject(int $guichetId, int $projetId): bool
    {
        $exists = GuichetProjet::where('guichet_id', $guichetId)
            ->where('projet_id', $projetId)
            ->exists();

        if ($exists) {
            return false;
        }

        GuichetProjet::create([
            'guichet_id' => $guichetId,
            'projet_id' => $projetId,
            'etat' => TypeEtat::ACTIF,
        ]);

        return true;
    }

    public function detachProject(int $guichetId, int $projetId): bool
    {
        $record = GuichetProjet::where('guichet_id', $guichetId)
            ->where('projet_id', $projetId)
            ->first();

        if (!$record) {
            return false;
        }

        return $record->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function getChiffres(int $id): Collection
    {
        return GuichetChiffre::where('guichet_id', $id)
            ->where('etat', TypeEtat::ACTIF)
            ->get();
    }

    public function addChiffre(int $guichetId, array $data): GuichetChiffre
    {
        $data['guichet_id'] = $guichetId;
        $data['etat'] = TypeEtat::ACTIF;
        return GuichetChiffre::create($data);
    }

    public function updateChiffre(int $chiffreId, array $data): GuichetChiffre
    {
        $chiffre = GuichetChiffre::find($chiffreId);
        if (!$chiffre) {
            throw new \Exception('Chiffre not found');
        }
        $chiffre->update($data);
        return $chiffre->fresh();
    }

    public function deleteChiffre(int $chiffreId): bool
    {
        $chiffre = GuichetChiffre::find($chiffreId);
        if (!$chiffre) {
            return false;
        }
        return $chiffre->update(['etat' => TypeEtat::SUPPRIME]);
    }
}
