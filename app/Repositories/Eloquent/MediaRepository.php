<?php

namespace App\Repositories\Eloquent;

use App\Models\Media;
use App\Repositories\Interfaces\MediaInterface;
use App\Types\TypeMedia;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;

class MediaRepository extends BaseRepository implements MediaInterface
{
    public function model(): string
    {
        return Media::class;
    }

    public function all(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->latest()
            ->get();
    }

    public function getPhotos(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('type_media', TypeMedia::PHOTO)
            ->latest()
            ->get();
    }

    public function getVideos(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('type_media', TypeMedia::VIDEO)
            ->latest()
            ->get();
    }

    public function getByType(int $type): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('type_media', $type)
            ->latest()
            ->get();
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where(function ($q) use ($query) {
                $q->where('description', 'LIKE', "%{$query}%")
                    ->orWhere('url', 'LIKE', "%{$query}%");
            })
            ->latest()
            ->get();
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->where('etat', TypeEtat::ACTIF)->count(),
            'photos' => $this->model->where('etat', TypeEtat::ACTIF)->where('type_media', TypeMedia::PHOTO)->count(),
            'videos' => $this->model->where('etat', TypeEtat::ACTIF)->where('type_media', TypeMedia::VIDEO)->count(),
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): Media
    {
        $data['etat'] = TypeEtat::ACTIF;
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $media = $this->find($id);
        if (!$media) {
            return false;
        }
        return $media->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $media = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$media) {
            return false;
        }
        return $media->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $media = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$media) {
            return false;
        }
        return $media->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }
}
