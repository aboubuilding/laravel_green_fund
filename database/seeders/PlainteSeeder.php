<?php

namespace Database\Seeders;

use App\Models\Plainte;
use App\Types\StatutPlainte;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;

class PlainteSeeder extends Seeder
{
    public function run(): void
    {
        $plaintes = [
            [
                'nom' => 'Koffi Mensah',
                'email' => 'koffi.mensah@example.com',
                'telephone' => '+228 90000010',
                'objet' => 'Non-respect des délais de paiement',
                'description' => 'Le paiement pour les travaux réalisés au mois de janvier n\'a pas été effectué dans les délais contractuels. Un retard de 45 jours est constaté.',
                'statut' => StatutPlainte::NOUVELLE,
                'reponse' => null,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Yao Adjei',
                'email' => 'yao.adjei@example.com',
                'telephone' => '+228 90000011',
                'objet' => 'Qualité des matériaux livrés',
                'description' => 'Les matériaux livrés pour le projet ne correspondent pas aux spécifications techniques. Une inspection a révélé des défauts de fabrication.',
                'statut' => StatutPlainte::EN_COURS,
                'reponse' => 'Nous avons contacté le fournisseur pour une vérification. Une inspection est prévue demain.',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Togbe Dosseh',
                'email' => 'togbe.dosseh@example.com',
                'telephone' => '+228 90000012',
                'objet' => 'Conflit d\'intérêts',
                'description' => 'Des irrégularités ont été constatées dans le processus d\'attribution du marché. Un membre du comité a des liens avec un soumissionnaire.',
                'statut' => StatutPlainte::NOUVELLE,
                'reponse' => null,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Afi Tchagba',
                'email' => 'afi.tchagba@example.com',
                'telephone' => '+228 90000013',
                'objet' => 'Absence de suivi technique',
                'description' => 'Aucun suivi technique n\'a été effectué depuis le début du projet. Les rapports d\'avancement ne sont pas disponibles.',
                'statut' => StatutPlainte::NOUVELLE,
                'reponse' => null,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Marie Abalo',
                'email' => 'marie.abalo@example.com',
                'telephone' => '+228 90000014',
                'objet' => 'Non-remise des rapports',
                'description' => 'Les rapports mensuels d\'activité ne nous sont pas communiqués depuis 4 mois. Malgré nos relances, aucune réponse n\'a été donnée.',
                'statut' => StatutPlainte::RESOLUE,
                'reponse' => 'Les rapports ont été transmis. Un système de rappel automatique a été mis en place pour éviter ce désagrément à l\'avenir.',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Kossi Akakpo',
                'email' => 'kossi.akakpo@example.com',
                'telephone' => '+228 90000015',
                'objet' => 'Dépassement de budget',
                'description' => 'Le projet a dépassé le budget initial de 35%. Aucune explication ni demande de validation préalable n\'a été fournie.',
                'statut' => StatutPlainte::EN_COURS,
                'reponse' => 'Une analyse des dépassements est en cours. Un rapport détaillé sera fourni sous 48h.',
                'etat' => TypeEtat::ACTIF,
            ],
        ];

        foreach ($plaintes as $plainte) {
            Plainte::updateOrCreate(
                [
                    'nom' => $plainte['nom'],
                    'objet' => $plainte['objet'],
                ],
                $plainte
            );
        }
    }
}
