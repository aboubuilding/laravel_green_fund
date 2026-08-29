<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuichetChiffreRequest;
use App\Http\Requests\GuichetRequest;
use App\Services\GuichetService;
use App\Services\ProjetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class GuichetController extends Controller
{
    protected GuichetService $guichetService;
    protected ProjetService $projetService;

    public function __construct(GuichetService $guichetService, ProjetService $projetService)
    {
        $this->guichetService = $guichetService;
        $this->projetService = $projetService;
    }

    public function index()
    {
        $guichets = $this->guichetService->getAll();
        $stats = $this->guichetService->getStats();

        return view('guichets.index', compact('guichets', 'stats'));
    }

    public function store(GuichetRequest $request): JsonResponse
    {
        try {
            $guichet = $this->guichetService->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Guichet créé avec succès.',
                'guichet' => $guichet,
                'stats' => $this->guichetService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(GuichetRequest $request, int $id): JsonResponse
    {
        try {
            $guichet = $this->guichetService->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Guichet mis à jour avec succès.',
                'guichet' => $guichet,
                'stats' => $this->guichetService->getStats(),
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
            $this->guichetService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Guichet supprimé avec succès.',
                'stats' => $this->guichetService->getStats(),
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
        $guichet = $this->guichetService->find($id);
        if (!$guichet) {
            return response()->json(['success' => false, 'message' => 'Guichet non trouvé'], 404);
        }

        $chiffres = $this->guichetService->getChiffres($id);
        $projets = $this->guichetService->getProjects($id);
        $allProjets = $this->projetService->getAll();

        return response()->json([
            'success' => true,
            'guichet' => $guichet,
            'chiffres' => $chiffres,
            'projets' => $projets,
            'all_projets' => $allProjets,
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $guichet = $this->guichetService->find($id);
        if (!$guichet) {
            return response()->json(['success' => false, 'message' => 'Guichet non trouvé'], 404);
        }

        return response()->json([
            'success' => true,
            'id' => $guichet->id,
            'nom' => $guichet->nom,
            'slug' => $guichet->slug,
            'description' => $guichet->description,
            'icone' => $guichet->icone,
        ]);
    }

    // ============================================
    // GESTION DES CHIFFRES CLÉS
    // ============================================

    public function addChiffre(GuichetChiffreRequest $request, int $id): JsonResponse
    {
        try {
            $chiffre = $this->guichetService->addChiffre($id, $request->validated());

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

    public function updateChiffre(GuichetChiffreRequest $request, int $chiffreId): JsonResponse
    {
        try {
            $chiffre = $this->guichetService->updateChiffre($chiffreId, $request->validated());

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
            $this->guichetService->deleteChiffre($chiffreId);

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

    public function attachProject(int $guichetId, int $projetId): JsonResponse
    {
        try {
            $this->guichetService->attachProject($guichetId, $projetId);

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

    public function detachProject(int $guichetId, int $projetId): JsonResponse
    {
        try {
            $this->guichetService->detachProject($guichetId, $projetId);

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
            $guichets = $this->guichetService->getActive();
        } elseif ($statut === 'inactive') {
            $guichets = $this->guichetService->getInactive();
        } else {
            $guichets = $this->guichetService->getAll();
        }

        $html = view('guichets._rows', compact('guichets'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $guichets->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $guichets = $this->guichetService->search($query);

        $html = view('guichets._rows', compact('guichets'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $guichets->count(),
            'query' => $query,
        ]);
    }
}
