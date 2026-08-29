<?php

namespace App\Repositories\Eloquent;

use App\Models\Soumission;
use App\Models\SoumissionHistorique;
use App\Repositories\Interfaces\SoumissionInterface;
use App\Types\StatutSoumission;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;

class SoumissionRepository extends BaseRepository implements SoumissionInterface
{
    public function model(): string
    {
        return Soumission::class;
    }

    public function all(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->with(['guichet', 'region', 'prefecture', 'commune', 'dernierHistorique'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByStatut(int $statut): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut_soumission', $statut)
            ->with(['guichet', 'region', 'prefecture', 'commune', 'dernierHistorique'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByGuichet(int $guichetId): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('guichet_id', $guichetId)
            ->with(['guichet', 'region', 'prefecture', 'commune', 'dernierHistorique'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByNumero(string $numero): ?Soumission
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('numero_soumission', $numero)
            ->with(['guichet', 'region', 'prefecture', 'commune', 'historiques' => function ($q) {
                $q->orderBy('date_action', 'desc');
            }])
            ->first();
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where(function ($q) use ($query) {
                $q->where('numero_soumission', 'LIKE', "%{$query}%")
                    ->orWhere('titre_projet', 'LIKE', "%{$query}%")
                    ->orWhere('porteur_nom', 'LIKE', "%{$query}%")
                    ->orWhere('porteur_email', 'LIKE', "%{$query}%");
            })
            ->with(['guichet', 'region', 'prefecture', 'commune', 'dernierHistorique'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->with(['guichet', 'region', 'prefecture', 'commune', 'dernierHistorique'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->where('etat', TypeEtat::ACTIF)->count(),
            'en_attente' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut_soumission', StatutSoumission::EN_ATTENTE)->count(),
            'en_cours' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut_soumission', StatutSoumission::EN_COURS)->count(),
            'approuves' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut_soumission', StatutSoumission::APPROUVE)->count(),
            'rejetes' => $this->model->where('etat', TypeEtat::ACTIF)->where('statut_soumission', StatutSoumission::REJETE)->count(),
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): Soumission
    {
        $data['etat'] = TypeEtat::ACTIF;
        $data['statut_soumission'] = StatutSoumission::EN_ATTENTE;
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $soumission = $this->find($id);
        if (!$soumission) {
            return false;
        }
        return $soumission->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $soumission = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$soumission) {
            return false;
        }
        return $soumission->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $soumission = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$soumission) {
            return false;
        }
        return $soumission->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }

    public function getHistoriques(int $soumissionId): Collection
    {
        return SoumissionHistorique::where('soumission_id', $soumissionId)
            ->where('etat', TypeEtat::ACTIF)
            ->with('auteur')
            ->orderBy('date_action', 'desc')
            ->get();
    }

    public function ajouterHistorique(int $soumissionId, int $statut, ?string $commentaire, int $auteurId): SoumissionHistorique
    {
        return SoumissionHistorique::create([
            'soumission_id' => $soumissionId,
            'statut_soumission' => $statut,
            'commentaire' => $commentaire,
            'auteur_id' => $auteurId,
            'date_action' => now(),
            'etat' => TypeEtat::ACTIF,
        ]);
    }

    public function changerStatut(int $soumissionId, int $statut, ?string $commentaire, int $auteurId): bool
    {
        $soumission = $this->find($soumissionId);
        if (!$soumission) {
            return false;
        }

        $soumission->update(['statut_soumission' => $statut]);
        $this->ajouterHistorique($soumissionId, $statut, $commentaire, $auteurId);

        return true;
    }
}
