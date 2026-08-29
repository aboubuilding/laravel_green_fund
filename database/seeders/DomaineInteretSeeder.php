<?php

namespace Database\Seeders;

use App\Models\DomaineInteret;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;

class DomaineInteretSeeder extends Seeder
{
    public function run(): void
    {
        $domaines = [
            ['libelle' => 'Énergie solaire', 'etat' => TypeEtat::ACTIF],
            ['libelle' => 'Eau et Assainissement', 'etat' => TypeEtat::ACTIF],
            ['libelle' => 'Agroforesterie', 'etat' => TypeEtat::ACTIF],
            ['libelle' => 'Reforestation', 'etat' => TypeEtat::ACTIF],
            ['libelle' => 'Éducation environnementale', 'etat' => TypeEtat::ACTIF],
            ['libelle' => 'Développement durable', 'etat' => TypeEtat::ACTIF],
            ['libelle' => 'Énergie renouvelable', 'etat' => TypeEtat::ACTIF],
            ['libelle' => 'Agriculture durable', 'etat' => TypeEtat::ACTIF],
        ];

        foreach ($domaines as $domaine) {
            DomaineInteret::updateOrCreate(
                ['libelle' => $domaine['libelle']],
                $domaine
            );
        }
    }
}
