<?php

namespace App\Repositories\Interfaces;

use App\Models\Plainte;
use Illuminate\Support\Collection;

interface PlainteInterface extends BaseRepositoryInterface
{
    public function getNouvelles(): Collection;
    public function getEnCours(): Collection;
    public function getResolues(): Collection;
    public function getByStatut(string $statut): Collection;
    public function search(string $query): Collection;
    public function getRecent(int $limit = 10): Collection;
    public function getStats(): array;
}
