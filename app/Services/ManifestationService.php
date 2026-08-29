<?php

namespace App\Services;

use App\Models\Manifestation;
use App\Repositories\Interfaces\ManifestationInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ManifestationService
{
    protected ManifestationInterface $manifestationRepository;

    public function __construct(ManifestationInterface $manifestationRepository)
    {
        $this->manifestationRepository = $manifestationRepository;
    }

    public function getAll(): Collection
    {
        return $this->manifestationRepository->all();
    }

    public function getNouvelles(): Collection
    {
        return $this->manifestationRepository->getNouvelles();
    }

    public function getTraitees(): Collection
    {
        return $this->manifestationRepository->getTraitees();
    }

    public function getByStatut(int $statut): Collection
    {
        return $this->manifestationRepository->getByStatut($statut);
    }

    public function getByGuichet(int $guichetId): Collection
    {
        return $this->manifestationRepository->getByGuichet($guichetId);
    }

    public function getByDomaine(int $domaineId): Collection
    {
        return $this->manifestationRepository->getByDomaine($domaineId);
    }

    public function find(int $id): \Illuminate\Database\Eloquent\Model
    {
        return $this->manifestationRepository->find($id);
    }

    public function create(array $data): Manifestation
    {
        return $this->manifestationRepository->create($data);
    }

    public function update(int $id, array $data): \Illuminate\Database\Eloquent\Model
    {
        return $this->manifestationRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        $manifestation = $this->find($id);
        if ($manifestation && $manifestation->document_manifestation && Storage::disk('public')->exists($manifestation->document_manifestation)) {
            Storage::disk('public')->delete($manifestation->document_manifestation);
        }
        return $this->manifestationRepository->delete($id);
    }

    public function restore(int $id): bool
    {
        return $this->manifestationRepository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        $manifestation = $this->find($id);
        if ($manifestation && $manifestation->document_manifestation && Storage::disk('public')->exists($manifestation->document_manifestation)) {
            Storage::disk('public')->delete($manifestation->document_manifestation);
        }
        return $this->manifestationRepository->forceDelete($id);
    }

    public function getTrashed(): Collection
    {
        return $this->manifestationRepository->getTrashed();
    }

    public function search(string $query): Collection
    {
        return $this->manifestationRepository->search($query);
    }

    public function getRecent(int $limit = 10): Collection
    {
        return $this->manifestationRepository->getRecent($limit);
    }

    public function getStats(): array
    {
        return $this->manifestationRepository->getStats();
    }

    public function traiter(int $id): bool
    {
        return $this->manifestationRepository->traiter($id);
    }

    public function uploadDocument($file, string $directory = 'manifestations'): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $path = $file->storeAs($directory, $filename, 'public');
        return $path;
    }

    public function deleteDocument(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return true;
    }

    public function exportCsv(): string
    {
        $manifestations = $this->getAll();
        $filename = 'manifestations_' . date('Y-m-d_H-i-s') . '.csv';

        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['ID', 'Nom', 'Prénom', 'Email', 'Téléphone', 'Type organisation', 'Guichet', 'Domaine intérêt', 'Message', 'Statut', 'Date']);

        foreach ($manifestations as $manifestation) {
            fputcsv($handle, [
                $manifestation->id,
                $manifestation->nom,
                $manifestation->prenom,
                $manifestation->email,
                $manifestation->telephone,
                $manifestation->type_organisation_label,
                $manifestation->nom_guichet,
                $manifestation->domaine_interet_libelle,
                $manifestation->message,
                $manifestation->statut_label,
                $manifestation->date_formatee,
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return $content;
    }

    public function sendEmail(int $id, string $subject, string $content): bool
    {
        $manifestation = $this->find($id);
        if (!$manifestation || !$manifestation->email) {
            return false;
        }

        try {
            Mail::raw($content, function ($message) use ($manifestation, $subject) {
                $message->to($manifestation->email)
                    ->subject($subject)
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
