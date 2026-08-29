<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaRequest;
use App\Services\MediaService;
use App\Types\TypeMedia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    protected MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function index()
    {
        $media = $this->mediaService->getAll();
        $stats = $this->mediaService->getStats();
        $types = TypeMedia::list();

        return view('media.index', compact('media', 'stats', 'types'));
    }

    public function store(MediaRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('fichier')) {
                $path = $this->mediaService->uploadMedia($request->file('fichier'));
                $data['url'] = $path;

                // Générer la miniature pour les photos
                if ($data['type_media'] == TypeMedia::PHOTO) {
                    $thumbPath = $this->mediaService->generateThumbnail($path);
                    if ($thumbPath) {
                        $data['miniature'] = $thumbPath;
                    }
                } else {
                    // Pour les vidéos, utiliser une miniature par défaut
                    $data['miniature'] = 'media/video-placeholder.jpg';
                }
            }

            $media = $this->mediaService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Média ajouté avec succès.',
                'media' => $media,
                'stats' => $this->mediaService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(MediaRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();

            $existingMedia = $this->mediaService->find($id);

            if ($request->hasFile('fichier')) {
                // Supprimer l'ancien fichier
                if ($existingMedia && $existingMedia->url) {
                    $this->mediaService->deleteMedia($existingMedia->url);
                }
                if ($existingMedia && $existingMedia->miniature) {
                    $this->mediaService->deleteMedia($existingMedia->miniature);
                }

                $path = $this->mediaService->uploadMedia($request->file('fichier'));
                $data['url'] = $path;

                if ($data['type_media'] == TypeMedia::PHOTO) {
                    $thumbPath = $this->mediaService->generateThumbnail($path);
                    if ($thumbPath) {
                        $data['miniature'] = $thumbPath;
                    }
                } else {
                    $data['miniature'] = 'media/video-placeholder.jpg';
                }
            }

            $media = $this->mediaService->update($id, $data);

            return response()->json([
                'success' => true,
                'message' => 'Média mis à jour avec succès.',
                'media' => $media,
                'stats' => $this->mediaService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->mediaService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Média supprimé avec succès.',
                'stats' => $this->mediaService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function filter(Request $request): JsonResponse
    {
        $type = $request->get('type');

        if ($type) {
            $media = $this->mediaService->getByType((int) $type);
        } else {
            $media = $this->mediaService->getAll();
        }

        $html = view('media._grid', compact('media'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $media->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $media = $this->mediaService->search($query);

        $html = view('media._grid', compact('media'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $media->count(),
            'query' => $query,
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $media = $this->mediaService->find($id);
        if (!$media) {
            return response()->json(['success' => false, 'message' => 'Média non trouvé'], 404);
        }

        return response()->json([
            'success' => true,
            'id' => $media->id,
            'type_media' => $media->type_media,
            'description' => $media->description,
            'date' => $media->date ? $media->date->format('Y-m-d') : null,
            'url' => $media->url,
            'miniature' => $media->miniature,
        ]);
    }
}
