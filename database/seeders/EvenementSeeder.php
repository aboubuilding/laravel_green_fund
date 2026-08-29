<?php

namespace Database\Seeders;

use App\Models\Evenement;
use App\Types\TypeEvenement;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class EvenementSeeder extends Seeder
{
    public function run(): void
    {
        // S'assurer que le dossier existe
        Storage::disk('public')->makeDirectory('evenements');

        $evenements = [
            [
                'titre' => 'Webinaire sur l\'agroforesterie',
                'description' => 'Formation sur les bonnes pratiques d\'agroforesterie au Togo. Animé par des experts internationaux.',
                'date_evenement' => now()->addDays(5),
                'lieu' => 'En ligne',
                'type_evenement' => TypeEvenement::WEBINAIRE,
                'image' => 'evenements/webinaire-agroforesterie.jpg',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Comité de suivi des projets Green Togo',
                'description' => 'Réunion trimestrielle du comité de suivi des projets en cours. Bilan et perspectives.',
                'date_evenement' => now()->addDays(12),
                'lieu' => 'Siège TogoGreenFund, Lomé',
                'type_evenement' => TypeEvenement::SEMINAIRE,
                'image' => 'evenements/comite-suivi.jpg',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Appel à projets : Session 2026',
                'description' => 'Date limite de dépôt des projets pour la session 2026. Ne manquez pas cette opportunité de financement.',
                'date_evenement' => now()->addDays(20),
                'lieu' => 'En ligne',
                'type_evenement' => TypeEvenement::CONFERENCE,
                'image' => 'evenements/appel-projets-2026.jpg',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Atelier de formation des porteurs de projets',
                'description' => 'Atelier pratique pour aider les porteurs de projets à préparer leurs dossiers de financement.',
                'date_evenement' => now()->addDays(30),
                'lieu' => 'Centre de formation, Lomé',
                'type_evenement' => TypeEvenement::FORMATION,
                'image' => 'evenements/formation-porteurs.jpg',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Conférence sur l\'énergie solaire au Togo',
                'description' => 'Conférence sur les opportunités et défis de l\'énergie solaire au Togo.',
                'date_evenement' => now()->subDays(10),
                'lieu' => 'Palais des Congrès, Lomé',
                'type_evenement' => TypeEvenement::CONFERENCE,
                'image' => 'evenements/conference-solaire.jpg',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Brouillon - Forum des partenaires 2026',
                'description' => 'Forum annuel des partenaires de TogoGreenFund. En cours de préparation.',
                'date_evenement' => null,
                'lieu' => null,
                'type_evenement' => TypeEvenement::ATELIER,
                'image' => null,
                'etat' => 0, // Brouillon
            ],
        ];

        foreach ($evenements as $evenement) {
            Evenement::updateOrCreate(
                ['titre' => $evenement['titre']],
                $evenement
            );
        }

        // Créer des fichiers vides pour les démonstrations
        $files = [
            'evenements/webinaire-agroforesterie.jpg' => 'Image webinaire agroforesterie',
            'evenements/comite-suivi.jpg' => 'Image comité suivi',
            'evenements/appel-projets-2026.jpg' => 'Image appel projets 2026',
            'evenements/formation-porteurs.jpg' => 'Image formation porteurs',
            'evenements/conference-solaire.jpg' => 'Image conférence solaire',
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
