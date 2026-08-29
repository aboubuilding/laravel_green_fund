<?php

namespace Database\Seeders;

use App\Models\Projet;
use App\Models\TypeProjet;
use App\Models\Region;
use App\Models\Prefecture;
use App\Models\Commune;
use App\Types\StatutProjet;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProjetSeeder extends Seeder
{
    public function run(): void
    {
        // S'assurer que le dossier existe
        Storage::disk('public')->makeDirectory('projets');

        // Créer des types de projets
        $types = [
            ['libelle' => 'Énergie solaire', 'etat' => TypeEtat::ACTIF],
            ['libelle' => 'Eau et Assainissement', 'etat' => TypeEtat::ACTIF],
            ['libelle' => 'Agroforesterie', 'etat' => TypeEtat::ACTIF],
            ['libelle' => 'Reforestation', 'etat' => TypeEtat::ACTIF],
            ['libelle' => 'Éducation', 'etat' => TypeEtat::ACTIF],
            ['libelle' => 'Santé', 'etat' => TypeEtat::ACTIF],
        ];

        foreach ($types as $type) {
            TypeProjet::updateOrCreate(['libelle' => $type['libelle']], $type);
        }

        // Récupérer les régions, préfectures et communes existantes
        $regions = Region::where('etat', TypeEtat::ACTIF)->get();
        $prefectures = Prefecture::where('etat', TypeEtat::ACTIF)->get();
        $communes = Commune::where('etat', TypeEtat::ACTIF)->get();
        $types = TypeProjet::where('etat', TypeEtat::ACTIF)->get();

        $projets = [
            [
                'titre' => 'Installation solaire communautaire à Kpalimé',
                'slug' => 'installation-solaire-communautaire-kpalime',
                'description' => 'Projet d\'installation de panneaux solaires pour 150 foyers dans la commune de Kpalimé. Ce projet vise à fournir une énergie propre et durable aux communautés rurales.',
                'image' => 'projets/solaire-kpalime.jpg',
                'region_id' => $regions->first()?->id,
                'prefecture_id' => $prefectures->first()?->id,
                'commune_id' => $communes->first()?->id,
                'statut_projet' => StatutProjet::EN_COURS,
                'type_projet_id' => $types->where('libelle', 'Énergie solaire')->first()?->id,
                'budget' => 15500000,
                'date_debut' => '2025-01-15',
                'date_fin' => '2025-06-30',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Forage d\'eau potable à Tchamba',
                'slug' => 'forage-eau-potable-tchamba',
                'description' => 'Construction de 5 forages pour l\'approvisionnement en eau potable dans la région de Tchamba. Bénéficiaires : 2 500 personnes.',
                'image' => 'projets/forage-tchamba.jpg',
                'region_id' => $regions->skip(1)->first()?->id,
                'prefecture_id' => $prefectures->skip(1)->first()?->id,
                'commune_id' => $communes->skip(1)->first()?->id,
                'statut_projet' => StatutProjet::EN_COURS,
                'type_projet_id' => $types->where('libelle', 'Eau et Assainissement')->first()?->id,
                'budget' => 22000000,
                'date_debut' => '2025-02-10',
                'date_fin' => '2025-08-31',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Agroforesterie dans la région des Plateaux',
                'slug' => 'agroforesterie-region-plateaux',
                'description' => 'Plantation de 50 000 arbres fruitiers et forestiers dans la région des Plateaux. Impact : 200 agriculteurs formés.',
                'image' => 'projets/agroforesterie.jpg',
                'region_id' => $regions->skip(2)->first()?->id,
                'prefecture_id' => $prefectures->skip(2)->first()?->id,
                'commune_id' => $communes->skip(2)->first()?->id,
                'statut_projet' => StatutProjet::TERMINE,
                'type_projet_id' => $types->where('libelle', 'Agroforesterie')->first()?->id,
                'budget' => 8750000,
                'date_debut' => '2024-09-01',
                'date_fin' => '2025-03-31',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Reforestation de la forêt d\'Atakpamé',
                'slug' => 'reforestation-foret-atakpame',
                'description' => 'Projet de reforestation de 200 hectares de forêt dégradée dans la région d\'Atakpamé. Création de 50 emplois.',
                'image' => 'projets/reforestation-atakpame.jpg',
                'region_id' => $regions->skip(3)->first()?->id,
                'prefecture_id' => $prefectures->skip(3)->first()?->id,
                'commune_id' => $communes->skip(3)->first()?->id,
                'statut_projet' => StatutProjet::EN_COURS,
                'type_projet_id' => $types->where('libelle', 'Reforestation')->first()?->id,
                'budget' => 45000000,
                'date_debut' => '2025-03-01',
                'date_fin' => '2025-12-31',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Micro-réseaux solaires Kara',
                'slug' => 'micro-reseaux-solaires-kara',
                'description' => 'Installation de micro-réseaux solaires pour 5 villages dans la région de Kara. Bénéficiaires : 800 personnes.',
                'image' => 'projets/micro-reseaux-solaires.jpg',
                'region_id' => $regions->skip(4)->first()?->id,
                'prefecture_id' => $prefectures->skip(4)->first()?->id,
                'commune_id' => $communes->skip(4)->first()?->id,
                'statut_projet' => StatutProjet::A_VENIR,
                'type_projet_id' => $types->where('libelle', 'Énergie solaire')->first()?->id,
                'budget' => 18200000,
                'date_debut' => '2025-09-01',
                'date_fin' => '2026-03-31',
                'etat' => TypeEtat::ACTIF,
            ],
        ];

        foreach ($projets as $projet) {
            Projet::updateOrCreate(
                ['slug' => $projet['slug']],
                $projet
            );
        }

        // Créer des fichiers vides pour les démonstrations
        $files = [
            'projets/solaire-kpalime.jpg' => 'Image solaire Kpalimé',
            'projets/forage-tchamba.jpg' => 'Image forage Tchamba',
            'projets/agroforesterie.jpg' => 'Image agroforesterie',
            'projets/reforestation-atakpame.jpg' => 'Image reforestation Atakpamé',
            'projets/micro-reseaux-solaires.jpg' => 'Image micro-réseaux solaires',
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
