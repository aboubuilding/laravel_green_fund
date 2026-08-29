<?php

namespace App\Repositories\Interfaces;

use App\Models\Manifestation;
use Illuminate\Support\Collection;

interface ManifestationInterface extends BaseRepositoryInterface
{
    public function getNouvelles(): Collection;
    public function getTraitees(): Collection;
    public function getByStatut(int $statut): Collection;
    public function getByGuichet(int $guichetId): Collection;
    public function getByDomaine(int $domaineId): Collection;
    public function search(string $query): Collection;
    public function getRecent(int $limit = 10): Collection;
    public function getStats(): array;
    public function traiter(int $id): bool;
}
