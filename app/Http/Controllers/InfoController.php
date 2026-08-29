<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfoRequest;
use App\Services\InfoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    protected InfoService $infoService;

    public function __construct(InfoService $infoService)
    {
        $this->infoService = $infoService;
    }

    public function index()
    {
        $infos = $this->infoService->getAll();
        $stats = $this->infoService->getStats();

        return view('infos.index', compact('infos', 'stats'));
    }

    public function store(InfoRequest $request): JsonResponse
    {
        try {
            $info = $this->infoService->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Info créée avec succès.',
                'info' => $info,
                'stats' => $this->infoService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(InfoRequest $request, int $id): JsonResponse
    {
        try {
            $info = $this->infoService->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Info mise à jour avec succès.',
                'info' => $info,
                'stats' => $this->infoService->getStats(),
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
            $this->infoService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Info supprimée avec succès.',
                'stats' => $this->infoService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function toggleStatus(int $id): JsonResponse
    {
        try {
            $this->infoService->toggleStatus($id);
            $info = $this->infoService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès.',
                'info' => $info,
                'stats' => $this->infoService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut.',
            ], 500);
        }
    }

    public function filter(Request $request): JsonResponse
    {
        $statut = $request->get('statut');

        if ($statut === 'active') {
            $infos = $this->infoService->getActive();
        } elseif ($statut === 'inactive') {
            $infos = $this->infoService->getInactive();
        } else {
            $infos = $this->infoService->getAll();
        }

        $html = view('infos._rows', compact('infos'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $infos->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $infos = $this->infoService->search($query);

        $html = view('infos._rows', compact('infos'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $infos->count(),
            'query' => $query,
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $info = $this->infoService->find($id);
        if (!$info) {
            return response()->json(['success' => false, 'message' => 'Info non trouvée'], 404);
        }

        return response()->json([
            'success' => true,
            'id' => $info->id,
            'titre' => $info->titre,
            'contenu' => $info->contenu,
            'date' => $info->date ? $info->date->format('Y-m-d') : null,
        ]);
    }
}
