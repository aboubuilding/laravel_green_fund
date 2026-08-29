<?php

namespace Database\Seeders;

use App\Models\Politique;
use App\Types\TypePolitique;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PolitiqueSeeder extends Seeder
{
    public function run(): void
    {
        // S'assurer que le dossier existe
        Storage::disk('public')->makeDirectory('politiques');

        $politiques = [
            [
                'titre' => 'Politique générale de TogoGreenFund',
                'type_politique_id' => TypePolitique::POLITIQUE_GENERALE,
                'fichier' => 'politiques/politique-generale.pdf',
                'date' => '2024-01-15',
                'description' => 'Document cadre définissant les orientations stratégiques de TogoGreenFund',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Politique financière et de gestion des fonds',
                'type_politique_id' => TypePolitique::POLITIQUE_FINANCIERE,
                'fichier' => 'politiques/politique-financiere.pdf',
                'date' => '2024-02-20',
                'description' => 'Règles de gestion financière et de suivi des fonds alloués aux projets',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Politique environnementale et développement durable',
                'type_politique_id' => TypePolitique::POLITIQUE_ENVIRONNEMENTALE,
                'fichier' => 'politiques/politique-environnementale.pdf',
                'date' => '2024-03-10',
                'description' => 'Engagements environnementaux et critères de durabilité des projets',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Politique RH et gestion des talents',
                'type_politique_id' => TypePolitique::POLITIQUE_RH,
                'fichier' => 'politiques/politique-rh.pdf',
                'date' => '2024-04-05',
                'description' => 'Cadre de gestion des ressources humaines de TogoGreenFund',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Politique d\'achats et d\'approvisionnement',
                'type_politique_id' => TypePolitique::POLITIQUE_ACHATS,
                'fichier' => 'politiques/politique-achats.pdf',
                'date' => '2024-05-12',
                'description' => 'Procédures d\'achats et d\'approvisionnement pour les projets',
                'etat' => 0, // Brouillon
            ],
            [
                'titre' => 'Politique qualité et amélioration continue',
                'type_politique_id' => TypePolitique::POLITIQUE_QUALITE,
                'fichier' => 'politiques/politique-qualite.pdf',
                'date' => '2024-06-20',
                'description' => 'Standards de qualité et processus d\'amélioration continue',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Charte de transparence et de redevabilité',
                'type_politique_id' => TypePolitique::AUTRE,
                'fichier' => 'politiques/charte-transparence.pdf',
                'date' => '2024-07-15',
                'description' => 'Engagements de transparence et de redevabilité de TogoGreenFund',
                'etat' => TypeEtat::ACTIF,
            ],
        ];

        foreach ($politiques as $politique) {
            Politique::updateOrCreate(
                ['titre' => $politique['titre']],
                $politique
            );
        }

        // Créer des fichiers vides pour les démonstrations
        $files = [
            'politiques/politique-generale.pdf' => 'Contenu politique générale',
            'politiques/politique-financiere.pdf' => 'Contenu politique financière',
            'politiques/politique-environnementale.pdf' => 'Contenu politique environnementale',
            'politiques/politique-rh.pdf' => 'Contenu politique RH',
            'politiques/politique-achats.pdf' => 'Contenu politique achats',
            'politiques/politique-qualite.pdf' => 'Contenu politique qualité',
            'politiques/charte-transparence.pdf' => 'Contenu charte transparence',
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
