<?php

namespace App\Repositories\Interfaces;

use App\Models\Media;
use Illuminate\Support\Collection;

interface MediaInterface extends BaseRepositoryInterface
{
    public function getPhotos(): Collection;
    public function getVideos(): Collection;
    public function getByType(int $type): Collection;
    public function search(string $query): Collection;
    public function getRecent(int $limit = 10): Collection;
    public function getStats(): array;
}
