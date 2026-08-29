<?php

namespace Database\Seeders;

use App\Models\Grief;
use App\Models\Projet;
use App\Types\StatutGrief;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;

class GriefSeeder extends Seeder
{
    public function run(): void
    {
        $projets = Projet::where('etat', TypeEtat::ACTIF)->take(5)->get();

        $griefs = [
            [
                'nom' => 'Mohamed Tchacondoh',
                'email' => 'mohamed@example.com',
                'telephone' => '+228 90000001',
                'projet_concerne_id' => $projets->first()?->id,
                'description' => 'Non-respect des délais de paiement pour la phase 2 du projet. Le paiement prévu n\'a pas été effectué dans les délais contractuels.',
                'statut' => StatutGrief::NOUVEAU,
                'reponse' => null,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Afi Tchagba',
                'email' => 'afi@example.com',
                'telephone' => '+228 90000002',
                'projet_concerne_id' => $projets->skip(1)->first()?->id,
                'description' => 'Qualité des matériaux livrés pour le projet de reforestation. Les plants livrés présentent un taux de reprise inférieur à 70%.',
                'statut' => StatutGrief::EN_COURS,
                'reponse' => 'Nous avons contacté le fournisseur pour un remplacement des plants défectueux.',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Jean Komi',
                'email' => 'jean@example.com',
                'telephone' => '+228 90000003',
                'projet_concerne_id' => $projets->skip(2)->first()?->id,
                'description' => 'Conflit d\'intérêts dans l\'attribution du projet. Des irrégularités ont été constatées dans le processus d\'attribution.',
                'statut' => StatutGrief::NOUVEAU,
                'reponse' => null,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Pierre Adjei',
                'email' => 'pierre@example.com',
                'telephone' => '+228 90000004',
                'projet_concerne_id' => $projets->skip(3)->first()?->id,
                'description' => 'Absence de suivi technique sur le projet de forage. Aucun suivi technique n\'a été effectué depuis le début du projet.',
                'statut' => StatutGrief::NOUVEAU,
                'reponse' => null,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Marie Abalo',
                'email' => 'marie@example.com',
                'telephone' => '+228 90000005',
                'projet_concerne_id' => $projets->skip(4)->first()?->id,
                'description' => 'Non-remise des rapports d\'activité. Les rapports mensuels d\'activité ne nous sont pas communiqués depuis 3 mois.',
                'statut' => StatutGrief::RESOLU,
                'reponse' => 'Les rapports ont été transmis. Nous avons mis en place un système de rappel automatique.',
                'etat' => TypeEtat::ACTIF,
            ],
        ];

        foreach ($griefs as $grief) {
            Grief::updateOrCreate(
                [
                    'nom' => $grief['nom'],
                    'description' => $grief['description'],
                ],
                $grief
            );
        }
    }
}
