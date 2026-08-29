<?php

namespace App\Repositories\Eloquent;

use App\Models\ProjetFinance;
use App\Repositories\Interfaces\ProjetFinanceInterface;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;

class ProjetFinanceRepository extends BaseRepository implements ProjetFinanceInterface
{
    public function model(): string
    {
        return ProjetFinance::class;
    }

    public function all(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->with(['projet', 'partenaire'])
            ->orderBy('annee', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getMiseEnAvant(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('mise_en_avant', true)
            ->with(['projet', 'partenaire'])
            ->orderBy('annee', 'desc')
            ->get();
    }

    public function getByAnnee(int $annee): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('annee', $annee)
            ->with(['projet', 'partenaire'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByPartenaire(int $partenaireId): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('partenaire_id', $partenaireId)
            ->with(['projet', 'partenaire'])
            ->orderBy('annee', 'desc')
            ->get();
    }

    public function getByProjet(int $projetId): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('projet_id', $projetId)
            ->with(['projet', 'partenaire'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where(function ($q) use ($query) {
                $q->whereHas('projet', function ($sub) use ($query) {
                    $sub->where('titre', 'LIKE', "%{$query}%");
                })->orWhereHas('partenaire', function ($sub) use ($query) {
                    $sub->where('nom', 'LIKE', "%{$query}%");
                })->orWhere('annee', 'LIKE', "%{$query}%");
            })
            ->with(['projet', 'partenaire'])
            ->orderBy('annee', 'desc')
            ->get();
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->with(['projet', 'partenaire'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getStats(): array
    {
        $total = $this->model->where('etat', TypeEtat::ACTIF)->count();
        $miseEnAvant = $this->model->where('etat', TypeEtat::ACTIF)->where('mise_en_avant', true)->count();

        $montantTotal = $this->model->where('etat', TypeEtat::ACTIF)->sum('montant_finance');

        $annees = $this->model->where('etat', TypeEtat::ACTIF)
            ->select('annee')
            ->distinct()
            ->pluck('annee')
            ->toArray();

        return [
            'total' => $total,
            'mise_en_avant' => $miseEnAvant,
            'montant_total' => $montantTotal,
            'annees' => array_filter($annees),
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): ProjetFinance
    {
        $data['etat'] = TypeEtat::ACTIF;
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $projetFinance = $this->find($id);
        if (!$projetFinance) {
            return false;
        }
        return $projetFinance->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $projetFinance = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$projetFinance) {
            return false;
        }
        return $projetFinance->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $projetFinance = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$projetFinance) {
            return false;
        }
        return $projetFinance->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }

    public function toggleMiseEnAvant(int $id): bool
    {
        $projetFinance = $this->find($id);
        if (!$projetFinance) {
            return false;
        }
        return $projetFinance->update(['mise_en_avant' => !$projetFinance->mise_en_avant]);
    }

    public function getAnneesDisponibles(): array
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->select('annee')
            ->distinct()
            ->orderBy('annee', 'desc')
            ->pluck('annee')
            ->toArray();
    }
}
