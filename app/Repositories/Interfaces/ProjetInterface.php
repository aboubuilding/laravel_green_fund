<?php

namespace App\Repositories\Interfaces;

use App\Models\Projet;
use Illuminate\Support\Collection;

interface ProjetInterface extends BaseRepositoryInterface
{
    public function getActive(): Collection;
    public function getBySlug(string $slug): ?Projet;
    public function getByStatut(int $statut): Collection;
    public function getByType(int $typeId): Collection;
    public function getByRegion(int $regionId): Collection;
    public function search(string $query): Collection;
    public function getRecent(int $limit = 10): Collection;
    public function getStats(): array;
}
