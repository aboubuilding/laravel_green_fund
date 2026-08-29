<?php

namespace Database\Seeders;

use App\Models\Facilite;
use App\Models\FaciliteChiffre;
use App\Models\FaciliteProjet;
use App\Models\Projet;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;

class FaciliteSeeder extends Seeder
{
    public function run(): void
    {
        $facilites = [
            [
                'nom' => 'Facilité Secteur Privé',
                'slug' => 'facilite-secteur-prive',
                'description' => 'Financement des projets portés par des entreprises privées. Soutien à l\'innovation et à la croissance des PME.',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Facilité Collectivités Territoriales',
                'slug' => 'facilite-collectivites-territoriales',
                'description' => 'Financement des projets portés par les collectivités territoriales. Soutien au développement local et aux infrastructures.',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Facilité ONG et Associations',
                'slug' => 'facilite-ong-associations',
                'description' => 'Financement des projets portés par les ONG et associations. Soutien aux initiatives communautaires et sociales.',
                'etat' => TypeEtat::ACTIF,
            ],
        ];

        foreach ($facilites as $facilite) {
            Facilite::updateOrCreate(
                ['slug' => $facilite['slug']],
                $facilite
            );
        }

        // Ajouter des chiffres clés pour chaque facilité
        $chiffres = [
            [
                'facilite_slug' => 'facilite-secteur-prive',
                'chiffres' => [
                    ['valeur' => '15+', 'libelle' => 'Projets financés'],
                    ['valeur' => '500M', 'libelle' => 'FCFA mobilisés'],
                    ['valeur' => '30', 'libelle' => 'Entreprises soutenues'],
                ],
            ],
            [
                'facilite_slug' => 'facilite-collectivites-territoriales',
                'chiffres' => [
                    ['valeur' => '12+', 'libelle' => 'Projets financés'],
                    ['valeur' => '350M', 'libelle' => 'FCFA mobilisés'],
                    ['valeur' => '15', 'libelle' => 'Collectivités soutenues'],
                ],
            ],
            [
                'facilite_slug' => 'facilite-ong-associations',
                'chiffres' => [
                    ['valeur' => '20+', 'libelle' => 'Projets financés'],
                    ['valeur' => '250M', 'libelle' => 'FCFA mobilisés'],
                    ['valeur' => '45', 'libelle' => 'ONG/Associations soutenues'],
                ],
            ],
        ];

        foreach ($chiffres as $item) {
            $facilite = Facilite::where('slug', $item['facilite_slug'])->first();
            if ($facilite) {
                foreach ($item['chiffres'] as $chiffre) {
                    FaciliteChiffre::updateOrCreate(
                        [
                            'facilite_id' => $facilite->id,
                            'libelle' => $chiffre['libelle'],
                        ],
                        [
                            'valeur' => $chiffre['valeur'],
                            'etat' => TypeEtat::ACTIF,
                        ]
                    );
                }
            }
        }

        // Associer des projets existants
        $projets = Projet::where('etat', TypeEtat::ACTIF)->take(5)->get();
        $facilitesList = Facilite::where('etat', TypeEtat::ACTIF)->get();

        foreach ($facilitesList as $facilite) {
            foreach ($projets as $projet) {
                FaciliteProjet::updateOrCreate(
                    [
                        'facilite_id' => $facilite->id,
                        'projet_id' => $projet->id,
                    ],
                    ['etat' => TypeEtat::ACTIF]
                );
            }
        }
    }
}
