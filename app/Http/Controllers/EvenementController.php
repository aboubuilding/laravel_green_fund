<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvenementRequest;
use App\Services\EvenementService;
use App\Types\TypeEvenement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvenementController extends Controller
{
    protected EvenementService $evenementService;

    public function __construct(EvenementService $evenementService)
    {
        $this->evenementService = $evenementService;
    }

    public function index()
    {
        $evenements = $this->evenementService->getAll();
        $stats = $this->evenementService->getStats();
        $types = TypeEvenement::list();

        return view('evenements.index', compact('evenements', 'stats', 'types'));
    }

    public function store(EvenementRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $path = $this->evenementService->uploadImage($request->file('image'));
                $data['image'] = $path;
            }

            $evenement = $this->evenementService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Événement créé avec succès.',
                'evenement' => $evenement,
                'stats' => $this->evenementService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(EvenementRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $existing = $this->evenementService->find($id);
                if ($existing && $existing->image) {
                    $this->evenementService->deleteImage($existing->image);
                }
                $path = $this->evenementService->uploadImage($request->file('image'));
                $data['image'] = $path;
            }

            $evenement = $this->evenementService->update($id, $data);

            return response()->json([
                'success' => true,
                'message' => 'Événement mis à jour avec succès.',
                'evenement' => $evenement,
                'stats' => $this->evenementService->getStats(),
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
            $this->evenementService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Événement supprimé avec succès.',
                'stats' => $this->evenementService->getStats(),
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
            $this->evenementService->publish($id);
            $evenement = $this->evenementService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Événement publié avec succès.',
                'evenement' => $evenement,
                'stats' => $this->evenementService->getStats(),
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
            $this->evenementService->unpublish($id);
            $evenement = $this->evenementService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Événement retiré de la publication.',
                'evenement' => $evenement,
                'stats' => $this->evenementService->getStats(),
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
        $type = $request->get('type');

        $evenements = $this->evenementService->getAll();

        if ($statut === 'upcoming') {
            $evenements = $this->evenementService->getUpcoming();
        } elseif ($statut === 'past') {
            $evenements = $this->evenementService->getPast();
        }

        if ($type) {
            $evenements = $this->evenementService->getByType((int) $type);
        }

        $html = view('evenements._rows', compact('evenements'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $evenements->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $evenements = $this->evenementService->search($query);

        $html = view('evenements._rows', compact('evenements'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $evenements->count(),
            'query' => $query,
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $evenement = $this->evenementService->find($id);
        if (!$evenement) {
            return response()->json(['success' => false, 'message' => 'Événement non trouvé'], 404);
        }

        return response()->json([
            'success' => true,
            'id' => $evenement->id,
            'titre' => $evenement->titre,
            'description' => $evenement->description,
            'date_evenement' => $evenement->date_evenement ? $evenement->date_evenement->format('Y-m-d') : null,
            'lieu' => $evenement->lieu,
            'type_evenement' => $evenement->type_evenement,
            'image' => $evenement->image,
            'image_url' => $evenement->image_url,
        ]);
    }
}
