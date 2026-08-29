<?php

namespace App\Services;

use App\Models\ProjetFinance;
use App\Repositories\Interfaces\ProjetFinanceInterface;
use Illuminate\Support\Collection;

class ProjetFinanceService
{
    protected ProjetFinanceInterface $projetFinanceRepository;

    public function __construct(ProjetFinanceInterface $projetFinanceRepository)
    {
        $this->projetFinanceRepository = $projetFinanceRepository;
    }

    public function getAll(): Collection
    {
        return $this->projetFinanceRepository->all();
    }

    public function getMiseEnAvant(): Collection
    {
        return $this->projetFinanceRepository->getMiseEnAvant();
    }

    public function getByAnnee(int $annee): Collection
    {
        return $this->projetFinanceRepository->getByAnnee($annee);
    }

    public function getByPartenaire(int $partenaireId): Collection
    {
        return $this->projetFinanceRepository->getByPartenaire($partenaireId);
    }

    public function getByProjet(int $projetId): Collection
    {
        return $this->projetFinanceRepository->getByProjet($projetId);
    }

    public function find(int $id): ?ProjetFinance
    {
        return $this->projetFinanceRepository->find($id);
    }

    public function create(array $data): ProjetFinance
    {
        return $this->projetFinanceRepository->create($data);
    }

    public function update(int $id, array $data): ProjetFinance
    {
        return $this->projetFinanceRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->projetFinanceRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->projetFinanceRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        return $this->projetFinanceRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->projetFinanceRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->projetFinanceRepository->search($query);
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->projetFinanceRepository->getRecent($limit);
    }

    public function getStats(): array
    {
        return $this->projetFinanceRepository->getStats();
    }

    public function toggleMiseEnAvant(int $id): bool
    {
        return $this->projetFinanceRepository->toggleMiseEnAvant($id);
    }

    public function getAnneesDisponibles(): array
    {
        return $this->projetFinanceRepository->getAnneesDisponibles();
    }
}
