<?php

namespace App\Repositories\Interfaces;

use App\Models\Document;
use Illuminate\Support\Collection;

interface DocumentInterface extends BaseRepositoryInterface
{
    public function findByCategory(int $categorie): Collection;
    public function findByType(string $type): Collection;
    public function search(string $query): Collection;
    public function getRecent(int $limit = 10): Collection;
    public function countByCategory(): array;
    public function getStats(): array;
}
