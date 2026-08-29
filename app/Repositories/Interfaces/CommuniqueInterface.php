<?php

namespace App\Repositories\Interfaces;

use App\Models\Communique;
use Illuminate\Support\Collection;

interface CommuniqueInterface extends BaseRepositoryInterface
{
    public function getPublished(): Collection;
    public function getDrafts(): Collection;
    public function search(string $query): Collection;
    public function getRecent(int $limit = 10): Collection;
    public function getStats(): array;
    public function publish(int $id): bool;
    public function unpublish(int $id): bool;
}
