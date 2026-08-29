<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualiteRequest;
use App\Services\ActualiteService;
use App\Types\StatutActualite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActualiteController extends Controller
{
    protected ActualiteService $actualiteService;

    public function __construct(ActualiteService $actualiteService)
    {
        $this->actualiteService = $actualiteService;
    }

    public function index()
    {
        $actualites = $this->actualiteService->getAll();
        $stats = $this->actualiteService->getStats();
        $statuts = StatutActualite::list();

        return view('actualites.index', compact('actualites', 'stats', 'statuts'));
    }

    public function store(ActualiteRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $path = $this->actualiteService->uploadImage($request->file('image'));
                $data['image'] = $path;
            }

            // Si publié et pas de date, mettre la date d'aujourd'hui
            if ($data['statut_actualite'] == StatutActualite::PUBLIE && empty($data['date_publication'])) {
                $data['date_publication'] = now()->toDateString();
            }

            $actualite = $this->actualiteService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Actualité créée avec succès.',
                'actualite' => $actualite,
                'stats' => $this->actualiteService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(ActualiteRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $existing = $this->actualiteService->find($id);
                if ($existing && $existing->image) {
                    $this->actualiteService->deleteImage($existing->image);
                }
                $path = $this->actualiteService->uploadImage($request->file('image'));
                $data['image'] = $path;
            }

            $actualite = $this->actualiteService->update($id, $data);

            return response()->json([
                'success' => true,
                'message' => 'Actualité mise à jour avec succès.',
                'actualite' => $actualite,
                'stats' => $this->actualiteService->getStats(),
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
            $this->actualiteService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Actualité supprimée avec succès.',
                'stats' => $this->actualiteService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function publish(int $id): JsonResponse
    {
        try {
            $this->actualiteService->publish($id);
            $actualite = $this->actualiteService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Actualité publiée avec succès.',
                'actualite' => $actualite,
                'stats' => $this->actualiteService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la publication.',
            ], 500);
        }
    }

    public function unpublish(int $id): JsonResponse
    {
        try {
            $this->actualiteService->unpublish($id);
            $actualite = $this->actualiteService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Actualité retirée de la publication.',
                'actualite' => $actualite,
                'stats' => $this->actualiteService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du retrait de la publication.',
            ], 500);
        }
    }

    public function filter(Request $request): JsonResponse
    {
        $statut = $request->get('statut');

        if ($statut === 'published') {
            $actualites = $this->actualiteService->getPublished();
        } elseif ($statut === 'drafts') {
            $actualites = $this->actualiteService->getDrafts();
        } else {
            $actualites = $this->actualiteService->getAll();
        }

        $html = view('actualites._rows', compact('actualites'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $actualites->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $actualites = $this->actualiteService->search($query);

        $html = view('actualites._rows', compact('actualites'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $actualites->count(),
            'query' => $query,
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $actualite = $this->actualiteService->find($id);
        if (!$actualite) {
            return response()->json(['success' => false, 'message' => 'Actualité non trouvée'], 404);
        }

        return response()->json([
            'success' => true,
            'id' => $actualite->id,
            'titre' => $actualite->titre,
            'slug' => $actualite->slug,
            'contenu' => $actualite->contenu,
            'extrait' => $actualite->extrait,
            'statut_actualite' => $actualite->statut_actualite,
            'date_publication' => $actualite->date_publication ? $actualite->date_publication->format('Y-m-d') : null,
            'image' => $actualite->image,
            'image_url' => $actualite->image_url,
        ]);
    }
}
