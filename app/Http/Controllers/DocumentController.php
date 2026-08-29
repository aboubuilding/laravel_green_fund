<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Services\DocumentService;
use App\Types\CategorieDocument;
use App\Types\TypeDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    protected DocumentService $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function index()
    {
        $documents = $this->documentService->getAll();
        $stats = $this->documentService->getStats();
        $categories = CategorieDocument::list();
        $types = TypeDocument::list();

        return view('documents.index', compact('documents', 'stats', 'categories', 'types'));
    }

    public function store(DocumentRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('fichier')) {
                $path = $this->documentService->uploadFile($request->file('fichier'));
                $data['url'] = $path;
                $data['format'] = $request->file('fichier')->getClientOriginalExtension();
                $data['taille'] = $request->file('fichier')->getSize();
            }

            $document = $this->documentService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Document créé avec succès.',
                'document' => $document,
                'stats' => $this->documentService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(DocumentRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('fichier')) {
                $document = $this->documentService->find($id);
                if ($document && $document->url) {
                    $this->documentService->deleteFile($document->url);
                }
                $path = $this->documentService->uploadFile($request->file('fichier'));
                $data['url'] = $path;
                $data['format'] = $request->file('fichier')->getClientOriginalExtension();
                $data['taille'] = $request->file('fichier')->getSize();
            }

            $document = $this->documentService->update($id, $data);

            return response()->json([
                'success' => true,
                'message' => 'Document mis à jour avec succès.',
                'document' => $document,
                'stats' => $this->documentService->getStats(),
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
            $this->documentService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Document supprimé avec succès.',
                'stats' => $this->documentService->getStats(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function download(int $id)
    {
        $document = $this->documentService->find($id);
        if (!$document) {
            abort(404, 'Document non trouvé');
        }

        if (Storage::disk('public')->exists($document->url)) {
            return Storage::disk('public')->download($document->url, $document->titre . '.' . $document->format);
        }

        abort(404, 'Fichier non trouvé');
    }

    public function filter(Request $request): JsonResponse
    {
        $category = $request->get('categorie');
        $type = $request->get('type');

        $documents = $this->documentService->getAll();

        if ($category) {
            $documents = $this->documentService->getByCategory((int) $category);
        }

        if ($type) {
            $documents = $this->documentService->getByType($type);
        }

        $html = view('documents._rows', compact('documents'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $documents->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $documents = $this->documentService->search($query);

        $html = view('documents._rows', compact('documents'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $documents->count(),
            'query' => $query,
        ]);
    }
}
