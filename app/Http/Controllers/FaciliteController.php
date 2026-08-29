<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaciliteChiffreRequest;
use App\Http\Requests\FaciliteRequest;
use App\Services\FaciliteService;
use App\Services\ProjetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaciliteController extends Controller
{
    protected FaciliteService $faciliteService;
    protected ProjetService $projetService;

    public function __construct(FaciliteService $faciliteService, ProjetService $projetService)
    {
        $this->faciliteService = $faciliteService;
        $this->projetService = $projetService;
    }

    public function index()
    {
        $facilites = $this->faciliteService->getAll();
        $stats = $this->faciliteService->getStats();

        return view('facilites.index', compact('facilites', 'stats'));
    }

    public function store(FaciliteRequest $request): JsonResponse
    {
        try {
            $facilite = $this->faciliteService->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Facilité créée avec succès.',
                'facilite' => $facilite,
                'stats' => $this->faciliteService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(FaciliteRequest $request, int $id): JsonResponse
    {
        try {
            $facilite = $this->faciliteService->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Facilité mise à jour avec succès.',
                'facilite' => $facilite,
                'stats' => $this->faciliteService->getStats(),
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
            $this->faciliteService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Facilité supprimée avec succès.',
                'stats' => $this->faciliteService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        $facilite = $this->faciliteService->find($id);
        if (!$facilite) {
            return response()->json(['success' => false, 'message' => 'Facilité non trouvée'], 404);
        }

        $chiffres = $this->faciliteService->getChiffres($id);
        $projets = $this->faciliteService->getProjects($id);
        $allProjets = $this->projetService->getAll();

        return response()->json([
            'success' => true,
            'facilite' => $facilite,
            'chiffres' => $chiffres,
            'projets' => $projets,
            'all_projets' => $allProjets,
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $facilite = $this->faciliteService->find($id);
        if (!$facilite) {
            return response()->json(['success' => false, 'message' => 'Facilité non trouvée'], 404);
        }

        return response()->json([
            'success' => true,
            'id' => $facilite->id,
            'nom' => $facilite->nom,
            'slug' => $facilite->slug,
            'description' => $facilite->description,
        ]);
    }

    // ============================================
    // GESTION DES CHIFFRES CLÉS
    // ============================================

    public function addChiffre(FaciliteChiffreRequest $request, int $id): JsonResponse
    {
        try {
            $chiffre = $this->faciliteService->addChiffre($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Chiffre clé ajouté avec succès.',
                'chiffre' => $chiffre,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout du chiffre clé.',
            ], 500);
        }
    }

    public function updateChiffre(FaciliteChiffreRequest $request, int $chiffreId): JsonResponse
    {
        try {
            $chiffre = $this->faciliteService->updateChiffre($chiffreId, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Chiffre clé mis à jour avec succès.',
                'chiffre' => $chiffre,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du chiffre clé.',
            ], 500);
        }
    }

    public function deleteChiffre(int $chiffreId): JsonResponse
    {
        try {
            $this->faciliteService->deleteChiffre($chiffreId);

            return response()->json([
                'success' => true,
                'message' => 'Chiffre clé supprimé avec succès.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du chiffre clé.',
            ], 500);
        }
    }

    // ============================================
    // GESTION DES PROJETS ASSOCIÉS
    // ============================================

    public function attachProject(int $faciliteId, int $projetId): JsonResponse
    {
        try {
            $this->faciliteService->attachProject($faciliteId, $projetId);

            return response()->json([
                'success' => true,
                'message' => 'Projet associé avec succès.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'association du projet.',
            ], 500);
        }
    }

    public function detachProject(int $faciliteId, int $projetId): JsonResponse
    {
        try {
            $this->faciliteService->detachProject($faciliteId, $projetId);

            return response()->json([
                'success' => true,
                'message' => 'Projet dissocié avec succès.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la dissociation du projet.',
            ], 500);
        }
    }

    public function filter(Request $request): JsonResponse
    {
        $statut = $request->get('statut');

        if ($statut === 'active') {
            $facilites = $this->faciliteService->getActive();
        } elseif ($statut === 'inactive') {
            $facilites = $this->faciliteService->getInactive();
        } else {
            $facilites = $this->faciliteService->getAll();
        }

        $html = view('facilites._rows', compact('facilites'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $facilites->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $facilites = $this->faciliteService->search($query);

        $html = view('facilites._rows', compact('facilites'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $facilites->count(),
            'query' => $query,
        ]);
    }
}
