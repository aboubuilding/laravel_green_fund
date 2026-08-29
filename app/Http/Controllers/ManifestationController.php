<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManifestationRequest;
use App\Services\ManifestationService;
use App\Services\GuichetService;
use App\Services\DomaineInteretService;
use App\Types\StatutManifestation;
use App\Types\TypeOrganisation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ManifestationController extends Controller
{
    protected ManifestationService $manifestationService;
    protected GuichetService $guichetService;
    protected DomaineInteretService $domaineInteretService;

    public function __construct(
        ManifestationService $manifestationService,
        GuichetService $guichetService,
        DomaineInteretService $domaineInteretService
    ) {
        $this->manifestationService = $manifestationService;
        $this->guichetService = $guichetService;
        $this->domaineInteretService = $domaineInteretService;
    }

    public function index()
    {
        $manifestations = $this->manifestationService->getAll();
        $stats = $this->manifestationService->getStats();
        $statuts = StatutManifestation::list();
        $typesOrganisation = TypeOrganisation::list();
        $guichets = $this->guichetService->getAll();
        $domaines = $this->domaineInteretService->getAll();

        return view('manifestations.index', compact(
            'manifestations',
            'stats',
            'statuts',
            'typesOrganisation',
            'guichets',
            'domaines'
        ));
    }

    public function store(ManifestationRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('document_manifestation')) {
                $path = $this->manifestationService->uploadDocument($request->file('document_manifestation'));
                $data['document_manifestation'] = $path;
            }

            $manifestation = $this->manifestationService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Manifestation créée avec succès.',
                'manifestation' => $manifestation,
                'stats' => $this->manifestationService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(ManifestationRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('document_manifestation')) {
                $existing = $this->manifestationService->find($id);
                if ($existing && $existing->document_manifestation) {
                    $this->manifestationService->deleteDocument($existing->document_manifestation);
                }
                $path = $this->manifestationService->uploadDocument($request->file('document_manifestation'));
                $data['document_manifestation'] = $path;
            }

            $manifestation = $this->manifestationService->update($id, $data);

            return response()->json([
                'success' => true,
                'message' => 'Manifestation mise à jour avec succès.',
                'manifestation' => $manifestation,
                'stats' => $this->manifestationService->getStats(),
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
            $this->manifestationService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Manifestation supprimée avec succès.',
                'stats' => $this->manifestationService->getStats(),
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
        $manifestation = $this->manifestationService->find($id);
        if (!$manifestation) {
            return response()->json(['success' => false, 'message' => 'Manifestation non trouvée'], 404);
        }

        return response()->json([
            'success' => true,
            'manifestation' => $manifestation,
            'statuts' => StatutManifestation::list(),
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $manifestation = $this->manifestationService->find($id);
        if (!$manifestation) {
            return response()->json(['success' => false, 'message' => 'Manifestation non trouvée'], 404);
        }

        return response()->json([
            'success' => true,
            'id' => $manifestation->id,
            'nom' => $manifestation->nom,
            'prenom' => $manifestation->prenom,
            'email' => $manifestation->email,
            'telephone' => $manifestation->telephone,
            'type_organisation' => $manifestation->type_organisation,
            'guichet_id' => $manifestation->guichet_id,
            'domaine_interet_id' => $manifestation->domaine_interet_id,
            'message' => $manifestation->message,
            'statut_manifestation' => $manifestation->statut_manifestation,
            'document_manifestation' => $manifestation->document_manifestation,
        ]);
    }

    public function traiter(int $id): JsonResponse
    {
        try {
            $this->manifestationService->traiter($id);
            $manifestation = $this->manifestationService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Manifestation marquée comme traitée.',
                'manifestation' => $manifestation,
                'stats' => $this->manifestationService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du traitement.',
            ], 500);
        }
    }

    public function envoyerEmail(Request $request, int $id): JsonResponse
    {
        try {
            $request->validate([
                'sujet' => 'required|string|max:255',
                'contenu' => 'required|string',
            ]);

            $sent = $this->manifestationService->sendEmail(
                $id,
                $request->get('sujet'),
                $request->get('contenu')
            );

            if (!$sent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible d\'envoyer l\'email. Vérifiez l\'adresse email.',
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Email envoyé avec succès.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function export()
    {
        try {
            $content = $this->manifestationService->exportCsv();
            $filename = 'manifestations_' . date('Y-m-d_H-i-s') . '.csv';

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
        $guichet = $request->get('guichet');
        $domaine = $request->get('domaine');

        $manifestations = $this->manifestationService->getAll();

        if ($statut && StatutManifestation::isValid((int) $statut)) {
            $manifestations = $this->manifestationService->getByStatut((int) $statut);
        }

        if ($guichet) {
            $manifestations = $this->manifestationService->getByGuichet((int) $guichet);
        }

        if ($domaine) {
            $manifestations = $this->manifestationService->getByDomaine((int) $domaine);
        }

        $html = view('manifestations._rows', compact('manifestations'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $manifestations->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $manifestations = $this->manifestationService->search($query);

        $html = view('manifestations._rows', compact('manifestations'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $manifestations->count(),
            'query' => $query,
        ]);
    }
}
