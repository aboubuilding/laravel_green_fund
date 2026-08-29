<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Types\CategorieDocument;
use App\Types\TypeDocument;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        // S'assurer que le dossier documents existe
        Storage::disk('public')->makeDirectory('documents');

        $documents = [
            [
                'titre' => 'Plan stratégique 2025-2030',
                'categorie_document' => CategorieDocument::PLAN,
                'type' => TypeDocument::RAPPORT,
                'format' => 'pdf',
                'taille' => 2457600, // 2.4 Mo
                'date' => '2025-01-15',
                'url' => 'documents/plan-strategique-2025-2030.pdf',
                'description' => 'Plan stratégique quinquennal de TogoGreenFund',
            ],
            [
                'titre' => 'Politique de financement des projets verts',
                'categorie_document' => CategorieDocument::POLITIQUE,
                'type' => TypeDocument::GUIDE,
                'format' => 'pdf',
                'taille' => 1572864, // 1.5 Mo
                'date' => '2025-02-10',
                'url' => 'documents/politique-financement-projets-verts.pdf',
                'description' => 'Document cadre pour le financement des projets écologiques',
            ],
            [
                'titre' => 'Décret portant création de TogoGreenFund',
                'categorie_document' => CategorieDocument::DECRET,
                'type' => TypeDocument::CONTRAT,
                'format' => 'pdf',
                'taille' => 1048576, // 1 Mo
                'date' => '2024-06-20',
                'url' => 'documents/decret-creation-togogreenfund.pdf',
                'description' => 'Décret officiel portant création de TogoGreenFund',
            ],
            [
                'titre' => 'Rapport d\'activités 2024',
                'categorie_document' => CategorieDocument::RAPPORT,
                'type' => TypeDocument::RAPPORT,
                'format' => 'pdf',
                'taille' => 5242880, // 5 Mo
                'date' => '2025-01-30',
                'url' => 'documents/rapport-activites-2024.pdf',
                'description' => 'Rapport annuel d\'activités de l\'exercice 2024',
            ],
            [
                'titre' => 'Guide du porteur de projet',
                'categorie_document' => CategorieDocument::GUIDE,
                'type' => TypeDocument::GUIDE,
                'format' => 'pdf',
                'taille' => 3145728, // 3 Mo
                'date' => '2025-03-05',
                'url' => 'documents/guide-porteur-projet.pdf',
                'description' => 'Guide pratique à destination des porteurs de projets',
            ],
            [
                'titre' => 'Formulaire de demande de financement',
                'categorie_document' => CategorieDocument::AUTRE,
                'type' => TypeDocument::FORMULAIRE,
                'format' => 'docx',
                'taille' => 524288, // 512 Ko
                'date' => '2025-03-12',
                'url' => 'documents/formulaire-demande-financement.docx',
                'description' => 'Formulaire type pour les demandes de financement',
            ],
            [
                'titre' => 'Convention de partenariat type',
                'categorie_document' => CategorieDocument::POLITIQUE,
                'type' => TypeDocument::CONTRAT,
                'format' => 'pdf',
                'taille' => 786432, // 768 Ko
                'date' => '2025-02-25',
                'url' => 'documents/convention-partenariat-type.pdf',
                'description' => 'Modèle de convention de partenariat',
            ],
            [
                'titre' => 'Brochure TogoGreenFund',
                'categorie_document' => CategorieDocument::AUTRE,
                'type' => TypeDocument::BROCHURE,
                'format' => 'pdf',
                'taille' => 2097152, // 2 Mo
                'date' => '2025-01-10',
                'url' => 'documents/brochure-togogreenfund.pdf',
                'description' => 'Brochure de présentation de TogoGreenFund',
            ],
        ];

        foreach ($documents as $doc) {
            Document::updateOrCreate(
                ['titre' => $doc['titre']],
                [
                    'categorie_document' => $doc['categorie_document'],
                    'type' => $doc['type'],
                    'format' => $doc['format'],
                    'taille' => $doc['taille'],
                    'date' => $doc['date'],
                    'url' => $doc['url'],
                    'description' => $doc['description'],
                    'etat' => TypeEtat::ACTIF,
                ]
            );
        }

        // Créer des fichiers vides pour les démonstrations
        foreach ($documents as $doc) {
            $path = storage_path('app/public/' . $doc['url']);
            $dir = dirname($path);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            if (!file_exists($path)) {
                file_put_contents($path, 'Contenu du fichier: ' . $doc['titre']);
            }
        }
    }
}
