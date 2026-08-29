<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjetRequest;
use App\Services\ProjetService;
use App\Services\RegionService;
use App\Services\PrefectureService;
use App\Services\CommuneService;
use App\Services\TypeProjetService;
use App\Types\StatutProjet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    protected ProjetService $projetService;
    protected RegionService $regionService;
    protected PrefectureService $prefectureService;
    protected CommuneService $communeService;
    protected TypeProjetService $typeProjetService;

    public function __construct(
        ProjetService $projetService,
        RegionService $regionService,
        PrefectureService $prefectureService,
        CommuneService $communeService,
        TypeProjetService $typeProjetService
    ) {
        $this->projetService = $projetService;
        $this->regionService = $regionService;
        $this->prefectureService = $prefectureService;
        $this->communeService = $communeService;
        $this->typeProjetService = $typeProjetService;
    }

    public function index()
    {
        $projets = $this->projetService->getAll();
        $stats = $this->projetService->getStats();
        $statuts = StatutProjet::list();
        $regions = $this->regionService->getAll();
        $types = $this->typeProjetService->getAll();

        return view('projets.index', compact('projets', 'stats', 'statuts', 'regions', 'types'));
    }

    public function store(ProjetRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $path = $this->projetService->uploadImage($request->file('image'));
                $data['image'] = $path;
            }

            $projet = $this->projetService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Projet créé avec succès.',
                'projet' => $projet,
                'stats' => $this->projetService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(ProjetRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $existing = $this->projetService->find($id);
                if ($existing && $existing->image) {
                    $this->projetService->deleteImage($existing->image);
                }
                $path = $this->projetService->uploadImage($request->file('image'));
                $data['image'] = $path;
            }

            $projet = $this->projetService->update($id, $data);

            return response()->json([
                'success' => true,
                'message' => 'Projet mis à jour avec succès.',
                'projet' => $projet,
                'stats' => $this->projetService->getStats(),
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
            $this->projetService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Projet supprimé avec succès.',
                'stats' => $this->projetService->getStats(),
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
        $projet = $this->projetService->find($id);
        if (!$projet) {
            return response()->json(['success' => false, 'message' => 'Projet non trouvé'], 404);
        }

        return response()->json([
            'success' => true,
            'projet' => $projet,
            'statuts' => StatutProjet::list(),
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $projet = $this->projetService->find($id);
        if (!$projet) {
            return response()->json(['success' => false, 'message' => 'Projet non trouvé'], 404);
        }

        return response()->json([
            'success' => true,
            'id' => $projet->id,
            'titre' => $projet->titre,
            'slug' => $projet->slug,
            'description' => $projet->description,
            'image' => $projet->image,
            'region_id' => $projet->region_id,
            'prefecture_id' => $projet->prefecture_id,
            'commune_id' => $projet->commune_id,
            'statut_projet' => $projet->statut_projet,
            'type_projet_id' => $projet->type_projet_id,
            'budget' => $projet->budget,
            'date_debut' => $projet->date_debut ? $projet->date_debut->format('Y-m-d') : null,
            'date_fin' => $projet->date_fin ? $projet->date_fin->format('Y-m-d') : null,
        ]);
    }

    public function filter(Request $request): JsonResponse
    {
        $statut = $request->get('statut');
        $region = $request->get('region');
        $type = $request->get('type');

        $projets = $this->projetService->getAll();

        if ($statut && StatutProjet::isValid((int) $statut)) {
            $projets = $this->projetService->getByStatut((int) $statut);
        }

        if ($region) {
            $projets = $this->projetService->getByRegion((int) $region);
        }

        if ($type) {
            $projets = $this->projetService->getByType((int) $type);
        }

        $html = view('projets._rows', compact('projets'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $projets->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $projets = $this->projetService->search($query);

        $html = view('projets._rows', compact('projets'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $projets->count(),
            'query' => $query,
        ]);
    }
}
