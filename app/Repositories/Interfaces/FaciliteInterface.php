<?php

namespace App\Repositories\Interfaces;

use App\Models\Facilite;
use App\Models\FaciliteChiffre;
use Illuminate\Support\Collection;

interface FaciliteInterface extends BaseRepositoryInterface
{
    public function getActive(): Collection;
    public function getBySlug(string $slug): ?Facilite;
    public function search(string $query): Collection;
    public function getRecent(int $limit = 10): Collection;
    public function getStats(): array;
    public function getProjects(int $id): Collection;
    public function attachProject(int $faciliteId, int $projetId): bool;
    public function detachProject(int $faciliteId, int $projetId): bool;
    public function getChiffres(int $id): Collection;
    public function addChiffre(int $faciliteId, array $data): FaciliteChiffre;
    public function updateChiffre(int $chiffreId, array $data): FaciliteChiffre;
    public function deleteChiffre(int $chiffreId): bool;
}
