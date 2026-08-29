<?php

namespace Database\Seeders;

use App\Models\Communique;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CommuniqueSeeder extends Seeder
{
    public function run(): void
    {
        // S'assurer que le dossier existe
        Storage::disk('public')->makeDirectory('communiques');

        $communiques = [
            [
                'titre' => 'Communiqué officiel - Lancement du programme Green Togo Phase 3',
                'date_publication' => '2025-01-15',
                'resume' => 'Le gouvernement lance la phase 3 du programme Green Togo avec un budget de 500 millions FCFA pour soutenir les projets écologiques.',
                'document_url' => 'communiques/communique-green-togo-phase3.pdf',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Appel à candidatures - Comité de suivi des projets 2025',
                'date_publication' => '2025-02-10',
                'resume' => 'Un appel à candidatures est lancé pour le recrutement des membres du comité de suivi des projets 2025.',
                'document_url' => 'communiques/appel-candidatures-comite-suivi.pdf',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Résultats de la session de financement 2025',
                'date_publication' => '2025-03-05',
                'resume' => 'Les résultats de la session de financement 2025 sont publiés. 45 projets ont été retenus pour un montant total de 2,5 milliards FCFA.',
                'document_url' => 'communiques/resultats-financement-2025.pdf',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Partenariat stratégique avec la Banque Africaine de Développement',
                'date_publication' => '2025-04-20',
                'resume' => 'TogoGreenFund signe un partenariat stratégique avec la BAD pour mobiliser 50 millions de dollars supplémentaires.',
                'document_url' => 'communiques/partenariat-bad.pdf',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Brouillon - Nouvelle stratégie de financement 2026',
                'date_publication' => null,
                'resume' => 'Document de travail sur la nouvelle stratégie de financement 2026. En cours de validation interne.',
                'document_url' => 'communiques/strategie-financement-2026-brouillon.pdf',
                'etat' => 0, // Brouillon
            ],
            [
                'titre' => 'Communiqué - Session extraordinaire du conseil d\'administration',
                'date_publication' => '2025-05-15',
                'resume' => 'Une session extraordinaire du conseil d\'administration se tiendra le 15 juin 2025 pour valider le budget 2026.',
                'document_url' => 'communiques/session-extraordinaire-ca.pdf',
                'etat' => TypeEtat::ACTIF,
            ],
        ];

        foreach ($communiques as $communique) {
            Communique::updateOrCreate(
                ['titre' => $communique['titre']],
                $communique
            );
        }

        // Créer des fichiers vides pour les démonstrations
        $files = [
            'communiques/communique-green-togo-phase3.pdf' => 'Contenu communiqué Green Togo Phase 3',
            'communiques/appel-candidatures-comite-suivi.pdf' => 'Contenu appel candidatures',
            'communiques/resultats-financement-2025.pdf' => 'Contenu résultats financement',
            'communiques/partenariat-bad.pdf' => 'Contenu partenariat BAD',
            'communiques/strategie-financement-2026-brouillon.pdf' => 'Contenu stratégie financement brouillon',
            'communiques/session-extraordinaire-ca.pdf' => 'Contenu session extraordinaire CA',
        ];

        foreach ($files as $path => $content) {
            $fullPath = storage_path('app/public/' . $path);
            $dir = dirname($fullPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            if (!file_exists($fullPath)) {
                file_put_contents($fullPath, $content);
            }
        }
    }
}
