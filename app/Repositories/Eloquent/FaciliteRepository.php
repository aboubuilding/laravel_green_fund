<?php

namespace App\Repositories\Eloquent;

use App\Models\Facilite;
use App\Models\FaciliteChiffre;
use App\Models\FaciliteProjet;
use App\Repositories\Interfaces\FaciliteInterface;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;

class FaciliteRepository extends BaseRepository implements FaciliteInterface
{
    public function model(): string
    {
        return Facilite::class;
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

    public function getBySlug(string $slug): ?Facilite
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
        $totalProjets = FaciliteProjet::where('etat', TypeEtat::ACTIF)->count();

        return [
            'total' => $this->model->count(),
            'active' => $active,
            'inactive' => $this->model->where('etat', '!=', TypeEtat::ACTIF)->count(),
            'total_projets' => $totalProjets,
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): Facilite
    {
        $data['etat'] = TypeEtat::ACTIF;
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $facilite = $this->find($id);
        if (!$facilite) {
            return false;
        }

        FaciliteProjet::where('facilite_id', $id)->update(['etat' => TypeEtat::SUPPRIME]);
        FaciliteChiffre::where('facilite_id', $id)->update(['etat' => TypeEtat::SUPPRIME]);

        return $facilite->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $facilite = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$facilite) {
            return false;
        }

        FaciliteProjet::where('facilite_id', $id)->update(['etat' => TypeEtat::ACTIF]);
        FaciliteChiffre::where('facilite_id', $id)->update(['etat' => TypeEtat::ACTIF]);

        return $facilite->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $facilite = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$facilite) {
            return false;
        }

        FaciliteProjet::where('facilite_id', $id)->delete();
        FaciliteChiffre::where('facilite_id', $id)->delete();

        return $facilite->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }

    public function getProjects(int $id): Collection
    {
        return FaciliteProjet::where('facilite_id', $id)
            ->where('etat', TypeEtat::ACTIF)
            ->with('projet')
            ->get()
            ->pluck('projet');
    }

    public function attachProject(int $faciliteId, int $projetId): bool
    {
        $exists = FaciliteProjet::where('facilite_id', $faciliteId)
            ->where('projet_id', $projetId)
            ->exists();

        if ($exists) {
            return false;
        }

        FaciliteProjet::create([
            'facilite_id' => $faciliteId,
            'projet_id' => $projetId,
            'etat' => TypeEtat::ACTIF,
        ]);

        return true;
    }

    public function detachProject(int $faciliteId, int $projetId): bool
    {
        $record = FaciliteProjet::where('facilite_id', $faciliteId)
            ->where('projet_id', $projetId)
            ->first();

        if (!$record) {
            return false;
        }

        return $record->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function getChiffres(int $id): Collection
    {
        return FaciliteChiffre::where('facilite_id', $id)
            ->where('etat', TypeEtat::ACTIF)
            ->get();
    }

    public function addChiffre(int $faciliteId, array $data): FaciliteChiffre
    {
        $data['facilite_id'] = $faciliteId;
        $data['etat'] = TypeEtat::ACTIF;
        return FaciliteChiffre::create($data);
    }

    public function updateChiffre(int $chiffreId, array $data): FaciliteChiffre
    {
        $chiffre = FaciliteChiffre::find($chiffreId);
        if (!$chiffre) {
            throw new \Exception('Chiffre not found');
        }
        $chiffre->update($data);
        return $chiffre->fresh();
    }

    public function deleteChiffre(int $chiffreId): bool
    {
        $chiffre = FaciliteChiffre::find($chiffreId);
        if (!$chiffre) {
            return false;
        }
        return $chiffre->update(['etat' => TypeEtat::SUPPRIME]);
    }
}
