<?php

namespace App\Repositories\Interfaces;

use App\Models\Info;
use Illuminate\Support\Collection;

interface InfoInterface extends BaseRepositoryInterface
{
    public function getActive(): Collection;
    public function getInactive(): Collection;
    public function search(string $query): Collection;
    public function getRecent(int $limit = 10): Collection;
    public function getStats(): array;
    public function toggleStatus(int $id): bool;
}
