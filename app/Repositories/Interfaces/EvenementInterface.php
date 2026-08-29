<?php

namespace App\Repositories\Interfaces;

use App\Models\Evenement;
use Illuminate\Support\Collection;

interface EvenementInterface extends BaseRepositoryInterface
{
    public function getPublished(): Collection;
    public function getDrafts(): Collection;
    public function getUpcoming(): Collection;
    public function getPast(): Collection;
    public function getByType(int $type): Collection;
    public function search(string $query): Collection;
    public function getRecent(int $limit = 10): Collection;
    public function getStats(): array;
    public function publish(int $id): bool;
    public function unpublish(int $id): bool;
}
