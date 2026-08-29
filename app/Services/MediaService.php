<?php

namespace App\Services;

use App\Models\Media;
use App\Repositories\Interfaces\MediaInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class MediaService
{
    protected MediaInterface $mediaRepository;

    public function __construct(MediaInterface $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    public function getAll(): Collection
    {
        return $this->mediaRepository->all();
    }

    public function getPhotos(): Collection
    {
        return $this->mediaRepository->getPhotos();
    }

    public function getVideos(): Collection
    {
        return $this->mediaRepository->getVideos();
    }

    public function find(int $id): ?Media
    {
        return $this->mediaRepository->find($id);
    }

    public function create(array $data): Media
    {
        return $this->mediaRepository->create($data);
    }

    public function update(int $id, array $data): Media
    {
        return $this->mediaRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        $media = $this->find($id);
        if ($media) {
            if ($media->url && Storage::disk('public')->exists($media->url)) {
                Storage::disk('public')->delete($media->url);
            }
            if ($media->miniature && Storage::disk('public')->exists($media->miniature)) {
                Storage::disk('public')->delete($media->miniature);
            }
        }
        return $this->mediaRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->mediaRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        $media = $this->find($id);
        if ($media) {
            if ($media->url && Storage::disk('public')->exists($media->url)) {
                Storage::disk('public')->delete($media->url);
            }
            if ($media->miniature && Storage::disk('public')->exists($media->miniature)) {
                Storage::disk('public')->delete($media->miniature);
            }
        }
        return $this->mediaRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->mediaRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->mediaRepository->search($query);
    }

    public function getStats(): array
    {
        return $this->mediaRepository->getStats();
    }

    public function uploadMedia($file, string $directory = 'media'): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $path = $file->storeAs($directory, $filename, 'public');
        return $path;
    }

    public function generateThumbnail(string $path): ?string
    {
        try {
            $fullPath = storage_path('app/public/' . $path);
            $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
            $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];

            if (in_array(strtolower($extension), $imageTypes)) {
                $thumbPath = 'media/thumbs/' . pathinfo($path, PATHINFO_FILENAME) . '_thumb.' . $extension;
                $thumbFullPath = storage_path('app/public/' . $thumbPath);

                $manager = new ImageManager();
                $image = $manager->make($fullPath);
                $image->resize(300, 200, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $image->save($thumbFullPath);

                return $thumbPath;
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function deleteMedia(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return true;
    }
}
