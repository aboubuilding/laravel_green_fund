<?php

namespace App\Repositories\Interfaces;

use App\Models\Soumission;
use App\Models\SoumissionHistorique;
use Illuminate\Support\Collection;

interface SoumissionInterface extends BaseRepositoryInterface
{
    public function getByStatut(int $statut): Collection;
    public function getByGuichet(int $guichetId): Collection;
    public function getByNumero(string $numero): ?Soumission;
    public function search(string $query): Collection;
    public function getRecent(int $limit = 10): Collection;
    public function getStats(): array;
    public function getHistoriques(int $soumissionId): Collection;
    public function ajouterHistorique(int $soumissionId, int $statut, ?string $commentaire, int $auteurId): SoumissionHistorique;
    public function changerStatut(int $soumissionId, int $statut, ?string $commentaire, int $auteurId): bool;
}
