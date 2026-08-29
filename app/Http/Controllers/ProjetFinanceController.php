<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjetFinanceRequest;
use App\Services\ProjetFinanceService;
use App\Services\ProjetService;
use App\Services\PartenaireService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjetFinanceController extends Controller
{
    protected ProjetFinanceService $projetFinanceService;
    protected ProjetService $projetService;
    protected PartenaireService $partenaireService;

    public function __construct(
        ProjetFinanceService $projetFinanceService,
        ProjetService $projetService,
        PartenaireService $partenaireService
    ) {
        $this->projetFinanceService = $projetFinanceService;
        $this->projetService = $projetService;
        $this->partenaireService = $partenaireService;
    }

    public function index()
    {
        $projetFinances = $this->projetFinanceService->getAll();
        $stats = $this->projetFinanceService->getStats();
        $projets = $this->projetService->getAll();
        $partenaires = $this->partenaireService->getAll();
        $annees = $this->projetFinanceService->getAnneesDisponibles();

        return view('projet-finances.index', compact('projetFinances', 'stats', 'projets', 'partenaires', 'annees'));
    }

    public function store(ProjetFinanceRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['mise_en_avant'] = $request->has('mise_en_avant');

            $projetFinance = $this->projetFinanceService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Projet financé créé avec succès.',
                'projetFinance' => $projetFinance,
                'stats' => $this->projetFinanceService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(ProjetFinanceRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['mise_en_avant'] = $request->has('mise_en_avant');

            $projetFinance = $this->projetFinanceService->update($id, $data);

            return response()->json([
                'success' => true,
                'message' => 'Projet financé mis à jour avec succès.',
                'projetFinance' => $projetFinance,
                'stats' => $this->projetFinanceService->getStats(),
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
            $this->projetFinanceService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Projet financé supprimé avec succès.',
                'stats' => $this->projetFinanceService->getStats(),
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
        $projetFinance = $this->projetFinanceService->find($id);
        if (!$projetFinance) {
            return response()->json(['success' => false, 'message' => 'Projet financé non trouvé'], 404);
        }

        return response()->json([
            'success' => true,
            'projetFinance' => $projetFinance,
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $projetFinance = $this->projetFinanceService->find($id);
        if (!$projetFinance) {
            return response()->json(['success' => false, 'message' => 'Projet financé non trouvé'], 404);
        }

        return response()->json([
            'success' => true,
            'id' => $projetFinance->id,
            'projet_id' => $projetFinance->projet_id,
            'montant_finance' => $projetFinance->montant_finance,
            'partenaire_id' => $projetFinance->partenaire_id,
            'annee' => $projetFinance->annee,
            'mise_en_avant' => $projetFinance->mise_en_avant,
        ]);
    }

    public function toggleMiseEnAvant(int $id): JsonResponse
    {
        try {
            $this->projetFinanceService->toggleMiseEnAvant($id);
            $projetFinance = $this->projetFinanceService->find($id);

            return response()->json([
                'success' => true,
                'message' => $projetFinance->mise_en_avant
                    ? 'Projet mis en avant avec succès.'
                    : 'Projet retiré de la mise en avant.',
                'projetFinance' => $projetFinance,
                'stats' => $this->projetFinanceService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la mise en avant.',
            ], 500);
        }
    }

    public function filter(Request $request): JsonResponse
    {
        $annee = $request->get('annee');
        $partenaire = $request->get('partenaire');

        $projetFinances = $this->projetFinanceService->getAll();

        if ($annee) {
            $projetFinances = $this->projetFinanceService->getByAnnee((int) $annee);
        }

        if ($partenaire) {
            $projetFinances = $this->projetFinanceService->getByPartenaire((int) $partenaire);
        }

        $html = view('projet-finances._rows', compact('projetFinances'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $projetFinances->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $projetFinances = $this->projetFinanceService->search($query);

        $html = view('projet-finances._rows', compact('projetFinances'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $projetFinances->count(),
            'query' => $query,
        ]);
    }
}
