<?php

namespace App\Http\Controllers;

use App\Http\Requests\GriefRequest;
use App\Services\GriefService;
use App\Services\ProjetService;
use App\Types\StatutGrief;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GriefController extends Controller
{
    protected GriefService $griefService;
    protected ProjetService $projetService;

    public function __construct(GriefService $griefService, ProjetService $projetService)
    {
        $this->griefService = $griefService;
        $this->projetService = $projetService;
    }

    public function index()
    {
        $griefs = $this->griefService->getAll();
        $stats = $this->griefService->getStats();
        $statuts = StatutGrief::list();
        $projets = $this->projetService->getAll();

        return view('griefs.index', compact('griefs', 'stats', 'statuts', 'projets'));
    }

    public function store(GriefRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['statut'] = StatutGrief::NOUVEAU;

            $grief = $this->griefService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Grief créé avec succès.',
                'grief' => $grief,
                'stats' => $this->griefService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(GriefRequest $request, int $id): JsonResponse
    {
        try {
            $grief = $this->griefService->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Grief mis à jour avec succès.',
                'grief' => $grief,
                'stats' => $this->griefService->getStats(),
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
            $this->griefService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Grief supprimé avec succès.',
                'stats' => $this->griefService->getStats(),
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
        $grief = $this->griefService->find($id);
        if (!$grief) {
            return response()->json(['success' => false, 'message' => 'Grief non trouvé'], 404);
        }

        return response()->json([
            'success' => true,
            'grief' => $grief,
            'statuts' => StatutGrief::list(),
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $grief = $this->griefService->find($id);
        if (!$grief) {
            return response()->json(['success' => false, 'message' => 'Grief non trouvé'], 404);
        }

        return response()->json([
            'success' => true,
            'id' => $grief->id,
            'nom' => $grief->nom,
            'email' => $grief->email,
            'telephone' => $grief->telephone,
            'projet_concerne_id' => $grief->projet_concerne_id,
            'description' => $grief->description,
            'statut' => $grief->statut,
            'reponse' => $grief->reponse,
        ]);
    }

    public function changerStatut(Request $request, int $id): JsonResponse
    {
        try {
            $statut = $request->get('statut');

            if (!StatutGrief::isValid($statut)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Statut invalide.',
                ], 400);
            }

            $this->griefService->changerStatut($id, $statut);
            $grief = $this->griefService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès.',
                'grief' => $grief,
                'stats' => $this->griefService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut.',
            ], 500);
        }
    }

    public function repondre(Request $request, int $id): JsonResponse
    {
        try {
            $request->validate([
                'reponse' => 'required|string',
            ]);

            $this->griefService->repondre($id, $request->get('reponse'));
            $grief = $this->griefService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Réponse ajoutée avec succès.',
                'grief' => $grief,
                'stats' => $this->griefService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout de la réponse.',
            ], 500);
        }
    }

    public function cloturer(int $id): JsonResponse
    {
        try {
            $this->griefService->cloturer($id);
            $grief = $this->griefService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Grief clôturé avec succès.',
                'grief' => $grief,
                'stats' => $this->griefService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la clôture du grief.',
            ], 500);
        }
    }

    public function export()
    {
        try {
            $content = $this->griefService->exportCsv();
            $filename = 'griefs_' . date('Y-m-d_H-i-s') . '.csv';

            return response($content)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erreur lors de l\'export : ' . $e->getMessage());
        }
    }

    public function filter(Request $request): JsonResponse
    {
        $statut = $request->get('statut');

        if ($statut && StatutGrief::isValid($statut)) {
            $griefs = $this->griefService->getByStatut($statut);
        } else {
            $griefs = $this->griefService->getAll();
        }

        $html = view('griefs._rows', compact('griefs'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $griefs->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $griefs = $this->griefService->search($query);

        $html = view('griefs._rows', compact('griefs'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $griefs->count(),
            'query' => $query,
        ]);
    }
}
