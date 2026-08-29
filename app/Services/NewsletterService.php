<?php

namespace App\Services;

use App\Models\Newsletter;
use App\Repositories\Interfaces\NewsletterInterface;
use Illuminate\Support\Collection;

class NewsletterService
{
    protected NewsletterInterface $newsletterRepository;

    public function __construct(NewsletterInterface $newsletterRepository)
    {
        $this->newsletterRepository = $newsletterRepository;
    }

    public function getAll(): Collection
    {
        return $this->newsletterRepository->all();
    }

    public function getActive(): Collection
    {
        return $this->newsletterRepository->getActive();
    }

    public function getDesabonnes(): Collection
    {
        return $this->newsletterRepository->getDesabonnes();
    }

    public function find(int $id): ?Newsletter
    {
        return $this->newsletterRepository->find($id);
    }

    public function create(array $data): Newsletter
    {
        return $this->newsletterRepository->create($data);
    }

    public function delete(int $id): bool
    {
        return $this->newsletterRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->newsletterRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        return $this->newsletterRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->newsletterRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->newsletterRepository->search($query);
    }

    public function getStats(): array
    {
        return $this->newsletterRepository->getStats();
    }

    public function unsubscribe(int $id): bool
    {
        return $this->newsletterRepository->unsubscribe($id);
    }

    public function resubscribe(int $id): bool
    {
        return $this->newsletterRepository->resubscribe($id);
    }

    public function exportCsv(): string
    {
        $subscribers = $this->getAll();
        $filename = 'newsletter_abonnes_' . date('Y-m-d_H-i-s') . '.csv';

        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['Email', 'Statut', "Date d'inscription", 'Date de création']);

        foreach ($subscribers as $subscriber) {
            fputcsv($handle, [
                $subscriber->email,
                $subscriber->statut_label,
                $subscriber->date_inscription_formatee,
                $subscriber->created_at->format('d/m/Y H:i'),
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return $content;
    }

    public function getActiveEmails(): array
    {
        return $this->getActive()->pluck('email')->toArray();
    }

    public function countActive(): int
    {
        return $this->getActive()->count();
    }
}
