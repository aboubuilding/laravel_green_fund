<?php

namespace App\Repositories\Interfaces;

use App\Models\Grief;
use Illuminate\Support\Collection;

interface GriefInterface extends BaseRepositoryInterface
{
    public function getNouveaux(): Collection;
    public function getEnCours(): Collection;
    public function getResolus(): Collection;
    public function getByStatut(string $statut): Collection;
    public function search(string $query): Collection;
    public function getRecent(int $limit = 10): Collection;
    public function getStats(): array;
    public function getByProjet(int $projetId): Collection;
}
