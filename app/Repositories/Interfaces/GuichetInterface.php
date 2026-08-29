<?php

namespace App\Repositories\Interfaces;

use App\Models\Guichet;
use App\Models\GuichetChiffre;
use Illuminate\Support\Collection;

interface GuichetInterface extends BaseRepositoryInterface
{
    public function getActive(): Collection;
    public function getBySlug(string $slug): ?Guichet;
    public function search(string $query): Collection;
    public function getRecent(int $limit = 10): Collection;
    public function getStats(): array;
    public function getProjects(int $id): Collection;
    public function attachProject(int $guichetId, int $projetId): bool;
    public function detachProject(int $guichetId, int $projetId): bool;
    public function getChiffres(int $id): Collection;
    public function addChiffre(int $guichetId, array $data): GuichetChiffre;
    public function updateChiffre(int $chiffreId, array $data): GuichetChiffre;
    public function deleteChiffre(int $chiffreId): bool;
}
