<?php

namespace Database\Seeders;

use App\Models\Guichet;
use App\Models\GuichetChiffre;
use App\Models\GuichetProjet;
use App\Models\Projet;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;

class GuichetSeeder extends Seeder
{
    public function run(): void
    {
        $guichets = [
            [
                'nom' => 'Guichet Agriculture',
                'slug' => 'guichet-agriculture',
                'description' => 'Financement des projets agricoles et agroalimentaires. Soutien à l\'agriculture durable et à la sécurité alimentaire.',
                'icone' => 'fas fa-tractor',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Guichet Forêt',
                'slug' => 'guichet-foret',
                'description' => 'Financement des projets de reforestation, de gestion durable des forêts et de conservation de la biodiversité.',
                'icone' => 'fas fa-tree',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Guichet Eau',
                'slug' => 'guichet-eau',
                'description' => 'Financement des projets d\'eau potable, d\'assainissement et de gestion durable des ressources en eau.',
                'icone' => 'fas fa-water',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Guichet Énergie',
                'slug' => 'guichet-energie',
                'description' => 'Financement des projets d\'énergies renouvelables, d\'efficacité énergétique et d\'accès à l\'énergie.',
                'icone' => 'fas fa-bolt',
                'etat' => TypeEtat::ACTIF,
            ],
        ];

        foreach ($guichets as $guichet) {
            Guichet::updateOrCreate(
                ['slug' => $guichet['slug']],
                $guichet
            );
        }

        // Ajouter des chiffres clés pour chaque guichet
        $chiffres = [
            [
                'guichet_slug' => 'guichet-agriculture',
                'chiffres' => [
                    ['valeur' => '25+', 'libelle' => 'Projets financés'],
                    ['valeur' => '500M', 'libelle' => 'FCFA mobilisés'],
                    ['valeur' => '1 200', 'libelle' => 'Agriculteurs bénéficiaires'],
                ],
            ],
            [
                'guichet_slug' => 'guichet-foret',
                'chiffres' => [
                    ['valeur' => '15+', 'libelle' => 'Projets financés'],
                    ['valeur' => '300M', 'libelle' => 'FCFA mobilisés'],
                    ['valeur' => '50 000', 'libelle' => 'Arbres plantés'],
                ],
            ],
            [
                'guichet_slug' => 'guichet-eau',
                'chiffres' => [
                    ['valeur' => '20+', 'libelle' => 'Projets financés'],
                    ['valeur' => '400M', 'libelle' => 'FCFA mobilisés'],
                    ['valeur' => '5 000', 'libelle' => 'Personnes desservies'],
                ],
            ],
            [
                'guichet_slug' => 'guichet-energie',
                'chiffres' => [
                    ['valeur' => '18+', 'libelle' => 'Projets financés'],
                    ['valeur' => '350M', 'libelle' => 'FCFA mobilisés'],
                    ['valeur' => '3 000', 'libelle' => 'Foyers électrifiés'],
                ],
            ],
        ];

        foreach ($chiffres as $item) {
            $guichet = Guichet::where('slug', $item['guichet_slug'])->first();
            if ($guichet) {
                foreach ($item['chiffres'] as $chiffre) {
                    GuichetChiffre::updateOrCreate(
                        [
                            'guichet_id' => $guichet->id,
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

        // Associer des projets existants (si présents)
        $projets = Projet::where('etat', TypeEtat::ACTIF)->take(5)->get();
        $guichets = Guichet::where('etat', TypeEtat::ACTIF)->get();

        foreach ($guichets as $index => $guichet) {
            foreach ($projets as $projet) {
                GuichetProjet::updateOrCreate(
                    [
                        'guichet_id' => $guichet->id,
                        'projet_id' => $projet->id,
                    ],
                    ['etat' => TypeEtat::ACTIF]
                );
            }
        }
    }
}
