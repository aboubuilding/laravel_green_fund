<?php

namespace App\Repositories\Eloquent;

use App\Models\Document;
use App\Repositories\Interfaces\DocumentInterface;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;

class DocumentRepository extends BaseRepository implements DocumentInterface
{
    public function model(): string
    {
        return Document::class;
    }

    public function all(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->latest()
            ->get();
    }

    public function findByCategory(int $categorie): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('categorie_document', $categorie)
            ->latest()
            ->get();
    }

    public function findByType(string $type): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('type', $type)
            ->latest()
            ->get();
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where(function ($q) use ($query) {
                $q->where('titre', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->latest()
            ->get();
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function countByCategory(): array
    {
        $categories = [];
        $all = $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->select('categorie_document', \DB::raw('count(*) as total'))
            ->groupBy('categorie_document')
            ->get();

        foreach ($all as $item) {
            $categories[$item->categorie_document] = $item->total;
        }

        return $categories;
    }

    public function getStats(): array
    {
        return [
            'total' => $this->model->where('etat', TypeEtat::ACTIF)->count(),
            'by_category' => $this->countByCategory(),
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): Document
    {
        $data['etat'] = TypeEtat::ACTIF;
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $document = $this->find($id);
        if (!$document) {
            return false;
        }
        return $document->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $document = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$document) {
            return false;
        }
        return $document->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $document = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$document) {
            return false;
        }
        return $document->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }
}
