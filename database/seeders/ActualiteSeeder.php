<?php

namespace Database\Seeders;

use App\Models\Actualite;
use App\Types\StatutActualite;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ActualiteSeeder extends Seeder
{
    public function run(): void
    {
        // S'assurer que le dossier existe
        Storage::disk('public')->makeDirectory('actualites');

        $actualites = [
            [
                'titre' => 'Lancement de la phase 3 du programme "Green Togo"',
                'slug' => 'lancement-phase-3-green-togo',
                'extrait' => 'Le programme Green Togo entre dans sa troisième phase avec un budget de 500 millions FCFA pour soutenir les projets écologiques au Togo.',
                'contenu' => '<p>Le programme Green Togo entre dans sa troisième phase avec un budget de 500 millions FCFA pour soutenir les projets écologiques au Togo. Cette nouvelle phase vise à renforcer l\'impact des projets verts et à élargir le nombre de bénéficiaires.</p><p>Les porteurs de projets sont invités à soumettre leurs dossiers avant le 30 juin 2025. Les critères de sélection ont été simplifiés pour faciliter l\'accès aux financements.</p>',
                'image' => 'actualites/green-togo-phase3.jpg',
                'date_publication' => '2025-01-15',
                'statut_actualite' => StatutActualite::PUBLIE,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Appel à projets pour l\'énergie solaire au Togo',
                'slug' => 'appel-projets-energie-solaire-togo',
                'extrait' => 'Un appel à projets est lancé pour les initiatives solaires dans les zones rurales du Togo. Les candidatures sont ouvertes jusqu\'au 31 mars 2025.',
                'contenu' => '<p>Un appel à projets est lancé pour les initiatives solaires dans les zones rurales du Togo. Les candidatures sont ouvertes jusqu\'au 31 mars 2025.</p><p>Ce programme vise à électrifier 50 villages grâce à des solutions solaires innovantes. Les projets retenus bénéficieront d\'un financement allant jusqu\'à 50 millions FCFA.</p>',
                'image' => 'actualites/energie-solaire.jpg',
                'date_publication' => '2025-02-10',
                'statut_actualite' => StatutActualite::PUBLIE,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Résultats des projets 2025',
                'slug' => 'resultats-projets-2025',
                'extrait' => 'Les résultats de l\'évaluation des projets 2025 sont disponibles. 45 projets ont été financés pour un montant total de 2,5 milliards FCFA.',
                'contenu' => '<p>Les résultats de l\'évaluation des projets 2025 sont disponibles. 45 projets ont été financés pour un montant total de 2,5 milliards FCFA.</p><p>Les projets couvrent plusieurs secteurs : l\'énergie solaire, l\'agroforesterie, la gestion de l\'eau et la reforestation. Les bénéficiaires sont répartis sur l\'ensemble du territoire togolais.</p>',
                'image' => 'actualites/resultats-2025.jpg',
                'date_publication' => '2025-03-05',
                'statut_actualite' => StatutActualite::PUBLIE,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Nouveau partenariat avec la Banque Africaine de Développement',
                'slug' => 'partenariat-banque-africaine-developpement',
                'extrait' => 'TogoGreenFund signe un accord de partenariat avec la BAD pour renforcer le financement des projets verts au Togo.',
                'contenu' => '<p>TogoGreenFund signe un accord de partenariat avec la Banque Africaine de Développement pour renforcer le financement des projets verts au Togo.</p><p>Ce partenariat permettra de mobiliser 50 millions de dollars supplémentaires pour soutenir les initiatives écologiques et favoriser le développement durable au Togo.</p>',
                'image' => 'actualites/partenariat-bad.jpg',
                'date_publication' => '2025-04-20',
                'statut_actualite' => StatutActualite::PUBLIE,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Webinaire sur l\'agroforesterie',
                'slug' => 'webinaire-agroforesterie',
                'extrait' => 'Un webinaire sur les bonnes pratiques d\'agroforesterie sera organisé le 15 mai 2025. Inscrivez-vous dès maintenant.',
                'contenu' => '<p>Un webinaire sur les bonnes pratiques d\'agroforesterie sera organisé le 15 mai 2025. Inscrivez-vous dès maintenant pour participer à cet événement incontournable.</p><p>Des experts internationaux partageront leurs expériences sur la mise en place de systèmes agroforestiers durables au Togo.</p>',
                'image' => 'actualites/webinaire-agroforesterie.jpg',
                'date_publication' => '2025-05-01',
                'statut_actualite' => StatutActualite::PUBLIE,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Brouillon : Nouvelle stratégie de financement 2026',
                'slug' => 'strategie-financement-2026',
                'extrait' => 'La nouvelle stratégie de financement 2026 sera bientôt publiée. Restez connectés pour découvrir les nouvelles opportunités.',
                'contenu' => '<p>La nouvelle stratégie de financement 2026 sera bientôt publiée. Restez connectés pour découvrir les nouvelles opportunités de financement pour les projets verts au Togo.</p><p>Cette stratégie vise à simplifier les procédures et à augmenter le nombre de projets financés.</p>',
                'image' => null,
                'date_publication' => null,
                'statut_actualite' => StatutActualite::BROUILLON,
                'etat' => TypeEtat::ACTIF,
            ],
        ];

        foreach ($actualites as $actualite) {
            Actualite::updateOrCreate(
                ['slug' => $actualite['slug']],
                $actualite
            );
        }

        // Créer des fichiers vides pour les démonstrations
        $files = [
            'actualites/green-togo-phase3.jpg' => 'Image Green Togo Phase 3',
            'actualites/energie-solaire.jpg' => 'Image Energie Solaire',
            'actualites/resultats-2025.jpg' => 'Image Résultats 2025',
            'actualites/partenariat-bad.jpg' => 'Image Partenariat BAD',
            'actualites/webinaire-agroforesterie.jpg' => 'Image Webinaire Agroforesterie',
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
