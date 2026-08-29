<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlainteRequest;
use App\Services\PlainteService;
use App\Types\StatutPlainte;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlainteController extends Controller
{
    protected PlainteService $plainteService;

    public function __construct(PlainteService $plainteService)
    {
        $this->plainteService = $plainteService;
    }

    public function index()
    {
        $plaintes = $this->plainteService->getAll();
        $stats = $this->plainteService->getStats();
        $statuts = StatutPlainte::list();

        return view('plaintes.index', compact('plaintes', 'stats', 'statuts'));
    }

    public function store(PlainteRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['statut'] = StatutPlainte::NOUVELLE;

            $plainte = $this->plainteService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Plainte créée avec succès.',
                'plainte' => $plainte,
                'stats' => $this->plainteService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(PlainteRequest $request, int $id): JsonResponse
    {
        try {
            $plainte = $this->plainteService->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Plainte mise à jour avec succès.',
                'plainte' => $plainte,
                'stats' => $this->plainteService->getStats(),
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
            $this->plainteService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Plainte supprimée avec succès.',
                'stats' => $this->plainteService->getStats(),
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
        $plainte = $this->plainteService->find($id);
        if (!$plainte) {
            return response()->json(['success' => false, 'message' => 'Plainte non trouvée'], 404);
        }

        return response()->json([
            'success' => true,
            'plainte' => $plainte,
            'statuts' => StatutPlainte::list(),
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $plainte = $this->plainteService->find($id);
        if (!$plainte) {
            return response()->json(['success' => false, 'message' => 'Plainte non trouvée'], 404);
        }

        return response()->json([
            'success' => true,
            'id' => $plainte->id,
            'nom' => $plainte->nom,
            'email' => $plainte->email,
            'telephone' => $plainte->telephone,
            'objet' => $plainte->objet,
            'description' => $plainte->description,
            'statut' => $plainte->statut,
            'reponse' => $plainte->reponse,
        ]);
    }

    public function changerStatut(Request $request, int $id): JsonResponse
    {
        try {
            $statut = $request->get('statut');

            if (!StatutPlainte::isValid($statut)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Statut invalide.',
                ], 400);
            }

            $this->plainteService->changerStatut($id, $statut);
            $plainte = $this->plainteService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès.',
                'plainte' => $plainte,
                'stats' => $this->plainteService->getStats(),
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

            $this->plainteService->repondre($id, $request->get('reponse'));
            $plainte = $this->plainteService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Réponse ajoutée avec succès.',
                'plainte' => $plainte,
                'stats' => $this->plainteService->getStats(),
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
            $this->plainteService->cloturer($id);
            $plainte = $this->plainteService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Plainte clôturée avec succès.',
                'plainte' => $plainte,
                'stats' => $this->plainteService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la clôture de la plainte.',
            ], 500);
        }
    }

    public function export()
    {
        try {
            $content = $this->plainteService->exportCsv();
            $filename = 'plaintes_' . date('Y-m-d_H-i-s') . '.csv';

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

        if ($statut && StatutPlainte::isValid($statut)) {
            $plaintes = $this->plainteService->getByStatut($statut);
        } else {
            $plaintes = $this->plainteService->getAll();
        }

        $html = view('plaintes._rows', compact('plaintes'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $plaintes->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $plaintes = $this->plainteService->search($query);

        $html = view('plaintes._rows', compact('plaintes'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $plaintes->count(),
            'query' => $query,
        ]);
    }
}
