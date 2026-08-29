<?php

namespace App\Repositories\Eloquent;

use App\Models\Newsletter;
use App\Repositories\Interfaces\NewsletterInterface;
use App\Types\StatutNewsletter;
use App\Types\TypeEtat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class NewsletterRepository extends BaseRepository implements NewsletterInterface
{
    public function model(): string
    {
        return Newsletter::class;
    }

    public function all(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->latest()
            ->get();
    }

    public function getActive(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut', StatutNewsletter::ACTIF)
            ->latest()
            ->get();
    }

    public function getDesabonnes(): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('statut', StatutNewsletter::DESABONNE)
            ->latest()
            ->get();
    }

    public function findByEmail(string $email): ?Newsletter
    {
        return $this->model->where('email', $email)->first();
    }

    public function emailExists(string $email): bool
    {
        return $this->model->where('email', $email)->exists();
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->where('etat', TypeEtat::ACTIF)
            ->where('email', 'LIKE', "%{$query}%")
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

    public function getStats(): array
    {
        $total = $this->model->where('etat', TypeEtat::ACTIF)->count();
        $active = $this->model->where('etat', TypeEtat::ACTIF)->where('statut', StatutNewsletter::ACTIF)->count();
        $desabonnes = $this->model->where('etat', TypeEtat::ACTIF)->where('statut', StatutNewsletter::DESABONNE)->count();

        return [
            'total' => $total,
            'active' => $active,
            'desabonnes' => $desabonnes,
            'recent' => $this->getRecent(5)->count(),
        ];
    }

    public function create(array $data): Newsletter
    {
        $data['etat'] = TypeEtat::ACTIF;
        $data['date_inscription'] = now();
        return $this->model->create($data);
    }

    public function delete(int $id): bool
    {
        $newsletter = $this->find($id);
        if (!$newsletter) {
            return false;
        }
        return $newsletter->update(['etat' => TypeEtat::SUPPRIME]);
    }

    public function restore(int $id): bool
    {
        $newsletter = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$newsletter) {
            return false;
        }
        return $newsletter->update(['etat' => TypeEtat::ACTIF]);
    }

    public function forceDelete(int $id): bool
    {
        $newsletter = $this->model->where('etat', TypeEtat::SUPPRIME)->find($id);
        if (!$newsletter) {
            return false;
        }
        return $newsletter->delete();
    }

    public function getTrashed(): Collection
    {
        return $this->model->where('etat', TypeEtat::SUPPRIME)->get();
    }

    public function unsubscribe(int $id): bool
    {
        $newsletter = $this->find($id);
        if (!$newsletter) {
            return false;
        }
        return $newsletter->update(['statut' => StatutNewsletter::DESABONNE]);
    }

    public function resubscribe(int $id): bool
    {
        $newsletter = $this->find($id);
        if (!$newsletter) {
            return false;
        }
        return $newsletter->update(['statut' => StatutNewsletter::ACTIF]);
    }
}
