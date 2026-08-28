<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', $this->getData());
    }

    private function getData(): array
    {
        return [
            'user' => auth()->user(),
            'stats' => [
                'fcfas_mobilises' => 125_450_000,
                'projets_finances' => 24,
                'beneficiaires' => 1_847,
                'partenaires' => 32,
                'croissance_fcfas' => 12.5,
                'croissance_projets' => 8.3,
                'croissance_beneficiaires' => 15.7,
            ],
            'soumissions' => [
                ['projet' => 'Installation solaire à Kpalimé', 'porteur' => 'Jean Komi', 'montant' => 15_500_000, 'depose_le' => Carbon::now()->subDays(2), 'priorite' => 'haute'],
                ['projet' => 'Forage d\'eau à Tchamba', 'porteur' => 'Marie Abalo', 'montant' => 22_000_000, 'depose_le' => Carbon::now()->subDays(5), 'priorite' => 'moyenne'],
                ['projet' => 'Agroforesterie Plateaux', 'porteur' => 'Pierre Adjei', 'montant' => 8_750_000, 'depose_le' => Carbon::now()->subDays(1), 'priorite' => 'basse'],
                ['projet' => 'Reforestation Atakpamé', 'porteur' => 'Afi Tchagba', 'montant' => 45_000_000, 'depose_le' => Carbon::now()->subDays(3), 'priorite' => 'haute'],
                ['projet' => 'Micro-réseaux solaires Kara', 'porteur' => 'Kossi Akakpo', 'montant' => 18_200_000, 'depose_le' => Carbon::now()->subDays(7), 'priorite' => 'moyenne'],
            ],
            'griefs' => [
                ['type' => 'plainte', 'sujet' => 'Non-respect des délais', 'auteur' => 'Mohamed Tchacondoh', 'projet' => 'Installation solaire Kpalimé', 'reçu_le' => Carbon::now()->subDays(1), 'statut' => 'nouveau', 'priorite' => 'haute'],
                ['type' => 'grief', 'sujet' => 'Qualité des matériaux', 'auteur' => 'Afi Tchagba', 'projet' => 'Reforestation Atakpamé', 'reçu_le' => Carbon::now()->subDays(3), 'statut' => 'en_cours', 'priorite' => 'moyenne'],
                ['type' => 'plainte', 'sujet' => 'Conflit d\'intérêts', 'auteur' => 'Jean Komi', 'projet' => 'Agroforesterie Plateaux', 'reçu_le' => Carbon::now()->subDays(5), 'statut' => 'nouveau', 'priorite' => 'haute'],
                ['type' => 'grief', 'sujet' => 'Absence de suivi', 'auteur' => 'Pierre Adjei', 'projet' => 'Forage Tchamba', 'reçu_le' => Carbon::now()->subDays(2), 'statut' => 'nouveau', 'priorite' => 'basse'],
                ['type' => 'plainte', 'sujet' => 'Non-remise des rapports', 'auteur' => 'Marie Abalo', 'projet' => 'Électrification rurale', 'reçu_le' => Carbon::now()->subDays(10), 'statut' => 'en_cours', 'priorite' => 'basse'],
            ],
            'actualites' => [
                ['titre' => 'Lancement phase 3 Green Togo', 'contenu' => 'Le programme Green Togo entre dans sa troisième phase avec un budget de 500 millions FCFA.', 'categorie' => 'Programme', 'publie_le' => Carbon::now()->subHours(3), 'est_urgent' => true],
                ['titre' => 'Appel à projets solaire', 'contenu' => 'Un appel à projets est lancé pour les initiatives solaires.', 'categorie' => 'Appel à projets', 'publie_le' => Carbon::now()->subDays(1), 'est_urgent' => true],
                ['titre' => 'Résultats projets 2025', 'contenu' => 'Les résultats de l\'évaluation des projets 2025 sont disponibles.', 'categorie' => 'Évaluation', 'publie_le' => Carbon::now()->subDays(3), 'est_urgent' => false],
                ['titre' => 'Partenariat avec la BAD', 'contenu' => 'TogoGreenFund signe un accord avec la Banque Africaine de Développement.', 'categorie' => 'Partenariat', 'publie_le' => Carbon::now()->subDays(5), 'est_urgent' => false],
                ['titre' => 'Webinaire agroforesterie', 'contenu' => 'Webinaire sur les bonnes pratiques d\'agroforesterie le 15 mars.', 'categorie' => 'Événement', 'publie_le' => Carbon::now()->subDays(7), 'est_urgent' => false],
            ],
            'projets' => [
                ['titre' => 'Installation solaire Kpalimé', 'porteur' => 'Jean Komi', 'organisation' => 'Association Énergie Verte', 'montant_global' => 15_500_000, 'montant_collecte' => 9_300_000, 'taux_realisation' => 60, 'statut' => 'en_cours', 'categorie' => 'Énergie solaire'],
                ['titre' => 'Forage d\'eau Tchamba', 'porteur' => 'Marie Abalo', 'organisation' => 'ONG Eau et Vie', 'montant_global' => 22_000_000, 'montant_collecte' => 17_600_000, 'taux_realisation' => 80, 'statut' => 'en_cours', 'categorie' => 'Eau et Assainissement'],
                ['titre' => 'Agroforesterie Plateaux', 'porteur' => 'Pierre Adjei', 'organisation' => 'Coopérative Agricole', 'montant_global' => 8_750_000, 'montant_collecte' => 8_750_000, 'taux_realisation' => 100, 'statut' => 'termine', 'categorie' => 'Agroforesterie'],
                ['titre' => 'Reforestation Atakpamé', 'porteur' => 'Afi Tchagba', 'organisation' => 'Fondation Green Togo', 'montant_global' => 45_000_000, 'montant_collecte' => 31_500_000, 'taux_realisation' => 70, 'statut' => 'en_cours', 'categorie' => 'Reforestation'],
                ['titre' => 'Micro-réseaux solaires Kara', 'porteur' => 'Kossi Akakpo', 'organisation' => 'Société Énergie Durable', 'montant_global' => 18_200_000, 'montant_collecte' => 12_740_000, 'taux_realisation' => 70, 'statut' => 'en_cours', 'categorie' => 'Énergie solaire'],
            ],
            'evenements' => [
                ['titre' => 'Webinaire agroforesterie', 'date' => Carbon::now()->addDays(5), 'heure' => '14:00', 'type' => 'webinaire', 'lieu' => 'En ligne'],
                ['titre' => 'Comité de suivi Green Togo', 'date' => Carbon::now()->addDays(12), 'heure' => '09:30', 'type' => 'reunion', 'lieu' => 'Lomé'],
                ['titre' => 'Appel à projets 2026', 'date' => Carbon::now()->addDays(20), 'heure' => '08:00', 'type' => 'deadline', 'lieu' => 'En ligne'],
            ],
            'notifications' => [
                ['type' => 'success', 'message' => 'Projet "Installation solaire Kpalimé" a atteint 60%', 'date' => Carbon::now()->subHours(2), 'lue' => false],
                ['type' => 'warning', 'message' => 'Projet "Forage Tchamba" nécessite une attention', 'date' => Carbon::now()->subHours(5), 'lue' => false],
                ['type' => 'info', 'message' => 'Nouveau partenaire : BAD', 'date' => Carbon::now()->subDays(1), 'lue' => true],
                ['type' => 'danger', 'message' => '3 nouvelles plaintes déposées', 'date' => Carbon::now()->subDays(1), 'lue' => false],
            ],
            'activites' => [
                ['type' => 'investissement', 'utilisateur' => 'Koffi Mensah', 'action' => 'a investi 500 000 FCFA dans', 'projet' => 'Installation solaire Kpalimé', 'date' => Carbon::now()->subMinutes(15)],
                ['type' => 'projet', 'utilisateur' => 'Marie Abalo', 'action' => 'a soumis le projet', 'projet' => 'Forage Tchamba', 'date' => Carbon::now()->subHours(2)],
                ['type' => 'inscription', 'utilisateur' => 'Yao Adjei', 'action' => 's\'est inscrit', 'projet' => null, 'date' => Carbon::now()->subHours(4)],
                ['type' => 'avis', 'utilisateur' => 'Afi Tchagba', 'action' => 'a déposé un grief', 'projet' => 'Reforestation Atakpamé', 'date' => Carbon::now()->subHours(6)],
                ['type' => 'investissement', 'utilisateur' => 'Togbe Dosseh', 'action' => 'a investi 750 000 FCFA', 'projet' => 'Reforestation Atakpamé', 'date' => Carbon::now()->subHours(8)],
            ],
        ];
    }

    public function stats()
    {
        return response()->json([
            'fcfas_mobilises' => 125_450_000,
            'projets_finances' => 24,
            'beneficiaires' => 1_847,
            'partenaires' => 32,
        ]);
    }
}
