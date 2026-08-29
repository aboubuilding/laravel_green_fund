<?php

namespace App\Http\Controllers;

use App\Http\Requests\PolitiqueRequest;
use App\Services\PolitiqueService;
use App\Types\TypePolitique;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PolitiqueController extends Controller
{
    protected PolitiqueService $politiqueService;

    public function __construct(PolitiqueService $politiqueService)
    {
        $this->politiqueService = $politiqueService;
    }

    public function index()
    {
        $politiques = $this->politiqueService->getAll();
        $stats = $this->politiqueService->getStats();
        $types = TypePolitique::list();

        return view('politiques.index', compact('politiques', 'stats', 'types'));
    }

    public function store(PolitiqueRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('fichier')) {
                $path = $this->politiqueService->uploadFile($request->file('fichier'));
                $data['fichier'] = $path;
            }

            $politique = $this->politiqueService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Publication créée avec succès.',
                'politique' => $politique,
                'stats' => $this->politiqueService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(PolitiqueRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('fichier')) {
                $existing = $this->politiqueService->find($id);
                if ($existing && $existing->fichier) {
                    $this->politiqueService->deleteFile($existing->fichier);
                }
                $path = $this->politiqueService->uploadFile($request->file('fichier'));
                $data['fichier'] = $path;
            }

            $politique = $this->politiqueService->update($id, $data);

            return response()->json([
                'success' => true,
                'message' => 'Publication mise à jour avec succès.',
                'politique' => $politique,
                'stats' => $this->politiqueService->getStats(),
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
            $this->politiqueService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Publication supprimée avec succès.',
                'stats' => $this->politiqueService->getStats(),
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
            $this->politiqueService->publish($id);
            $politique = $this->politiqueService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Publication publiée avec succès.',
                'politique' => $politique,
                'stats' => $this->politiqueService->getStats(),
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
            $this->politiqueService->unpublish($id);
            $politique = $this->politiqueService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Publication retirée de la publication.',
                'politique' => $politique,
                'stats' => $this->politiqueService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du retrait de la publication.',
            ], 500);
        }
    }

    public function download(int $id)
    {
        $politique = $this->politiqueService->find($id);
        if (!$politique) {
            abort(404, 'Publication non trouvée');
        }

        if ($politique->fichier && Storage::disk('public')->exists($politique->fichier)) {
            return Storage::disk('public')->download($politique->fichier, $politique->titre . '.' . $politique->extension);
        }

        abort(404, 'Fichier non trouvé');
    }

    public function filter(Request $request): JsonResponse
    {
        $type = $request->get('type');

        if ($type) {
            $politiques = $this->politiqueService->getByType((int) $type);
        } else {
            $politiques = $this->politiqueService->getAll();
        }

        $html = view('politiques._rows', compact('politiques'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $politiques->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $politiques = $this->politiqueService->search($query);

        $html = view('politiques._rows', compact('politiques'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $politiques->count(),
            'query' => $query,
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $politique = $this->politiqueService->find($id);
        if (!$politique) {
            return response()->json(['success' => false, 'message' => 'Publication non trouvée'], 404);
        }

        return response()->json([
            'success' => true,
            'id' => $politique->id,
            'titre' => $politique->titre,
            'type_politique_id' => $politique->type_politique_id,
            'date' => $politique->date ? $politique->date->format('Y-m-d') : null,
            'description' => $politique->description,
            'fichier' => $politique->fichier,
        ]);
    }
}
