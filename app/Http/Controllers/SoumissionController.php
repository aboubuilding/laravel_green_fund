<?php

namespace App\Http\Controllers;

use App\Http\Requests\SoumissionRequest;
use App\Http\Requests\SoumissionStatutRequest;
use App\Services\SoumissionService;
use App\Services\GuichetService;
use App\Services\RegionService;
use App\Services\PrefectureService;
use App\Services\CommuneService;
use App\Types\StatutSoumission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoumissionController extends Controller
{
    protected SoumissionService $soumissionService;
    protected GuichetService $guichetService;
    protected RegionService $regionService;
    protected PrefectureService $prefectureService;
    protected CommuneService $communeService;

    public function __construct(
        SoumissionService $soumissionService,
        GuichetService $guichetService,
        RegionService $regionService,
        PrefectureService $prefectureService,
        CommuneService $communeService
    ) {
        $this->soumissionService = $soumissionService;
        $this->guichetService = $guichetService;
        $this->regionService = $regionService;
        $this->prefectureService = $prefectureService;
        $this->communeService = $communeService;
    }

    public function index()
    {
        $soumissions = $this->soumissionService->getAll();
        $stats = $this->soumissionService->getStats();
        $statuts = StatutSoumission::list();
        $guichets = $this->guichetService->getAll();
        $regions = $this->regionService->getAll();

        return view('soumissions.index', compact('soumissions', 'stats', 'statuts', 'guichets', 'regions'));
    }

    public function store(SoumissionRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            // Gestion des documents
            $docFields = ['doc_statut', 'attestation_fiscal', 'autre_document', 'doc_budget'];
            foreach ($docFields as $field) {
                if ($request->hasFile($field)) {
                    $path = $this->soumissionService->uploadDocument($request->file($field));
                    $data[$field] = $path;
                }
            }

            $soumission = $this->soumissionService->create($data);

            // Ajouter l'historique initial
            $this->soumissionService->changerStatut(
                $soumission->id,
                StatutSoumission::EN_ATTENTE,
                'Soumission créée',
                Auth::id()
            );

            return response()->json([
                'success' => true,
                'message' => 'Soumission créée avec succès.',
                'soumission' => $soumission,
                'stats' => $this->soumissionService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(SoumissionRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();

            // Gestion des documents
            $docFields = ['doc_statut', 'attestation_fiscal', 'autre_document', 'doc_budget'];
            foreach ($docFields as $field) {
                if ($request->hasFile($field)) {
                    $existing = $this->soumissionService->find($id);
                    if ($existing && $existing->$field) {
                        $this->soumissionService->deleteDocument($existing->$field);
                    }
                    $path = $this->soumissionService->uploadDocument($request->file($field));
                    $data[$field] = $path;
                }
            }

            $soumission = $this->soumissionService->update($id, $data);

            return response()->json([
                'success' => true,
                'message' => 'Soumission mise à jour avec succès.',
                'soumission' => $soumission,
                'stats' => $this->soumissionService->getStats(),
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
            $this->soumissionService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Soumission supprimée avec succès.',
                'stats' => $this->soumissionService->getStats(),
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
        $soumission = $this->soumissionService->find($id);
        if (!$soumission) {
            return response()->json(['success' => false, 'message' => 'Soumission non trouvée'], 404);
        }

        $historiques = $this->soumissionService->getHistoriques($id);

        return response()->json([
            'success' => true,
            'soumission' => $soumission,
            'historiques' => $historiques,
            'statuts' => StatutSoumission::list(),
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $soumission = $this->soumissionService->find($id);
        if (!$soumission) {
            return response()->json(['success' => false, 'message' => 'Soumission non trouvée'], 404);
        }

        return response()->json([
            'success' => true,
            'soumission' => $soumission,
        ]);
    }

    public function changerStatut(SoumissionStatutRequest $request, int $id): JsonResponse
    {
        try {
            $statut = $request->get('statut');
            $commentaire = $request->get('commentaire');

            $result = $this->soumissionService->changerStatut(
                $id,
                $statut,
                $commentaire,
                Auth::id()
            );

            if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de changer le statut.',
                ], 400);
            }

            $soumission = $this->soumissionService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès.',
                'soumission' => $soumission,
                'stats' => $this->soumissionService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du changement de statut.',
            ], 500);
        }
    }

    public function getHistoriques(int $id): JsonResponse
    {
        $historiques = $this->soumissionService->getHistoriques($id);

        return response()->json([
            'success' => true,
            'historiques' => $historiques,
        ]);
    }

    public function getMessagesPublic(int $id): JsonResponse
    {
        $messages = $this->soumissionService->getMessagesPublic($id);

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    public function filter(Request $request): JsonResponse
    {
        $statut = $request->get('statut');
        $guichet = $request->get('guichet');

        $soumissions = $this->soumissionService->getAll();

        if ($statut && StatutSoumission::isValid((int) $statut)) {
            $soumissions = $this->soumissionService->getByStatut((int) $statut);
        }

        if ($guichet) {
            $soumissions = $this->soumissionService->getByGuichet((int) $guichet);
        }

        $html = view('soumissions._rows', compact('soumissions'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $soumissions->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $soumissions = $this->soumissionService->search($query);

        $html = view('soumissions._rows', compact('soumissions'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $soumissions->count(),
            'query' => $query,
        ]);
    }
}
