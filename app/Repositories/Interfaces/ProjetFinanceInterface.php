<?php

namespace App\Repositories\Interfaces;

use App\Models\ProjetFinance;
use Illuminate\Support\Collection;

interface ProjetFinanceInterface extends BaseRepositoryInterface
{
    public function getMiseEnAvant(): Collection;
    public function getByAnnee(int $annee): Collection;
    public function getByPartenaire(int $partenaireId): Collection;
    public function getByProjet(int $projetId): Collection;
    public function search(string $query): Collection;
    public function getRecent(int $limit = 10): Collection;
    public function getStats(): array;
    public function toggleMiseEnAvant(int $id): bool;
    public function getAnneesDisponibles(): array;
}
