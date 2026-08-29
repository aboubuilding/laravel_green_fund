<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommuniqueRequest;
use App\Services\CommuniqueService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommuniqueController extends Controller
{
    protected CommuniqueService $communiqueService;

    public function __construct(CommuniqueService $communiqueService)
    {
        $this->communiqueService = $communiqueService;
    }

    public function index()
    {
        $communiques = $this->communiqueService->getAll();
        $stats = $this->communiqueService->getStats();

        return view('communiques.index', compact('communiques', 'stats'));
    }

    public function store(CommuniqueRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('document')) {
                $path = $this->communiqueService->uploadDocument($request->file('document'));
                $data['document_url'] = $path;
            }

            $communique = $this->communiqueService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Communiqué créé avec succès.',
                'communique' => $communique,
                'stats' => $this->communiqueService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(CommuniqueRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('document')) {
                $existing = $this->communiqueService->find($id);
                if ($existing && $existing->document_url) {
                    $this->communiqueService->deleteDocument($existing->document_url);
                }
                $path = $this->communiqueService->uploadDocument($request->file('document'));
                $data['document_url'] = $path;
            }

            $communique = $this->communiqueService->update($id, $data);

            return response()->json([
                'success' => true,
                'message' => 'Communiqué mis à jour avec succès.',
                'communique' => $communique,
                'stats' => $this->communiqueService->getStats(),
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
            $this->communiqueService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Communiqué supprimé avec succès.',
                'stats' => $this->communiqueService->getStats(),
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
            $this->communiqueService->publish($id);
            $communique = $this->communiqueService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Communiqué publié avec succès.',
                'communique' => $communique,
                'stats' => $this->communiqueService->getStats(),
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
            $this->communiqueService->unpublish($id);
            $communique = $this->communiqueService->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Communiqué retiré de la publication.',
                'communique' => $communique,
                'stats' => $this->communiqueService->getStats(),
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
        $communique = $this->communiqueService->find($id);
        if (!$communique) {
            abort(404, 'Communiqué non trouvé');
        }

        if ($communique->document_url && Storage::disk('public')->exists($communique->document_url)) {
            return Storage::disk('public')->download($communique->document_url, $communique->titre . '.pdf');
        }

        abort(404, 'Document non trouvé');
    }

    public function filter(Request $request): JsonResponse
    {
        $statut = $request->get('statut');

        if ($statut === 'published') {
            $communiques = $this->communiqueService->getPublished();
        } elseif ($statut === 'drafts') {
            $communiques = $this->communiqueService->getDrafts();
        } else {
            $communiques = $this->communiqueService->getAll();
        }

        $html = view('communiques._rows', compact('communiques'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $communiques->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $communiques = $this->communiqueService->search($query);

        $html = view('communiques._rows', compact('communiques'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $communiques->count(),
            'query' => $query,
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $communique = $this->communiqueService->find($id);
        if (!$communique) {
            return response()->json(['success' => false, 'message' => 'Communiqué non trouvé'], 404);
        }

        return response()->json([
            'success' => true,
            'id' => $communique->id,
            'titre' => $communique->titre,
            'date_publication' => $communique->date_publication ? $communique->date_publication->format('Y-m-d') : null,
            'resume' => $communique->resume,
            'document_url' => $communique->document_url,
        ]);
    }
}
