<?php

namespace App\Repositories\Interfaces;

use App\Models\Newsletter;
use Illuminate\Support\Collection;

interface NewsletterInterface extends BaseRepositoryInterface
{
    public function getActive(): Collection;
    public function getDesabonnes(): Collection;
    public function findByEmail(string $email): ?Newsletter;
    public function emailExists(string $email): bool;
    public function search(string $query): Collection;
    public function getRecent(int $limit = 10): Collection;
    public function getStats(): array;
    public function unsubscribe(int $id): bool;
    public function resubscribe(int $id): bool;
}
