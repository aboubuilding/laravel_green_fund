<?php

namespace Database\Seeders;

use App\Models\Soumission;
use App\Models\SoumissionHistorique;
use App\Models\User;
use App\Models\Guichet;
use App\Models\Region;
use App\Types\StatutSoumission;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;

class SoumissionSeeder extends Seeder
{
    public function run(): void
    {
        $guichets = Guichet::where('etat', TypeEtat::ACTIF)->get();
        $regions = Region::where('etat', TypeEtat::ACTIF)->get();
        $user = User::first();

        $soumissions = [
            [
                'numero_soumission' => 'SOU-2026-0001',
                'type_porteur' => 1,
                'porteur_nom' => 'Jean Komi',
                'porteur_fonction' => 'Directeur',
                'porteur_email' => 'jean.komi@example.com',
                'porteur_telephone' => '+228 90000030',
                'titre_projet' => 'Installation solaire communautaire à Kpalimé',
                'guichet_id' => $guichets->first()?->id,
                'region_id' => $regions->first()?->id,
                'montant_sollicite' => 15500000,
                'cout_global' => 18000000,
                'resume_projet' => 'Projet d\'installation de panneaux solaires pour 150 foyers.',
                'statut_soumission' => StatutSoumission::EN_COURS,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'numero_soumission' => 'SOU-2026-0002',
                'type_porteur' => 2,
                'porteur_nom' => 'Marie Abalo',
                'porteur_fonction' => 'Coordinatrice',
                'porteur_email' => 'marie.abalo@example.com',
                'porteur_telephone' => '+228 90000031',
                'titre_projet' => 'Forage d\'eau potable à Tchamba',
                'guichet_id' => $guichets->skip(1)->first()?->id,
                'region_id' => $regions->skip(1)->first()?->id,
                'montant_sollicite' => 22000000,
                'cout_global' => 25000000,
                'resume_projet' => 'Construction de 5 forages pour l\'approvisionnement en eau potable.',
                'statut_soumission' => StatutSoumission::EN_ATTENTE,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'numero_soumission' => 'SOU-2026-0003',
                'type_porteur' => 3,
                'porteur_nom' => 'Pierre Adjei',
                'porteur_fonction' => 'Président',
                'porteur_email' => 'pierre.adjei@example.com',
                'porteur_telephone' => '+228 90000032',
                'titre_projet' => 'Agroforesterie dans la région des Plateaux',
                'guichet_id' => $guichets->skip(2)->first()?->id,
                'region_id' => $regions->skip(2)->first()?->id,
                'montant_sollicite' => 8750000,
                'cout_global' => 10000000,
                'resume_projet' => 'Plantation de 50 000 arbres fruitiers et forestiers.',
                'statut_soumission' => StatutSoumission::APPROUVE,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'numero_soumission' => 'SOU-2026-0004',
                'type_porteur' => 4,
                'porteur_nom' => 'Afi Tchagba',
                'porteur_fonction' => 'Directrice',
                'porteur_email' => 'afi.tchagba@example.com',
                'porteur_telephone' => '+228 90000033',
                'titre_projet' => 'Reforestation de la forêt d\'Atakpamé',
                'guichet_id' => $guichets->skip(3)->first()?->id,
                'region_id' => $regions->skip(3)->first()?->id,
                'montant_sollicite' => 45000000,
                'cout_global' => 50000000,
                'resume_projet' => 'Projet de reforestation de 200 hectares de forêt dégradée.',
                'statut_soumission' => StatutSoumission::EN_COURS,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'numero_soumission' => 'SOU-2026-0005',
                'type_porteur' => 5,
                'porteur_nom' => 'Kossi Akakpo',
                'porteur_fonction' => 'Ingénieur',
                'porteur_email' => 'kossi.akakpo@example.com',
                'porteur_telephone' => '+228 90000034',
                'titre_projet' => 'Micro-réseaux solaires Kara',
                'guichet_id' => $guichets->skip(4)->first()?->id,
                'region_id' => $regions->skip(4)->first()?->id,
                'montant_sollicite' => 18200000,
                'cout_global' => 20000000,
                'resume_projet' => 'Installation de micro-réseaux solaires pour 5 villages.',
                'statut_soumission' => StatutSoumission::REJETE,
                'etat' => TypeEtat::ACTIF,
            ],
        ];

        foreach ($soumissions as $soumission) {
            Soumission::updateOrCreate(
                ['numero_soumission' => $soumission['numero_soumission']],
                $soumission
            );
        }

        // Ajouter des historiques
        $soumissionList = Soumission::where('etat', TypeEtat::ACTIF)->get();
        foreach ($soumissionList as $soumission) {
            // Historique initial
            SoumissionHistorique::create([
                'soumission_id' => $soumission->id,
                'statut_soumission' => StatutSoumission::EN_ATTENTE,
                'commentaire' => 'Soumission créée',
                'auteur_id' => $user?->id,
                'date_action' => $soumission->created_at,
                'etat' => TypeEtat::ACTIF,
            ]);

            // Historique de changement
            if ($soumission->statut_soumission != StatutSoumission::EN_ATTENTE) {
                SoumissionHistorique::create([
                    'soumission_id' => $soumission->id,
                    'statut_soumission' => $soumission->statut_soumission,
                    'commentaire' => 'Changement de statut vers ' . $soumission->statut_label,
                    'auteur_id' => $user?->id,
                    'date_action' => now()->subDays(rand(1, 10)),
                    'etat' => TypeEtat::ACTIF,
                ]);
            }
        }
    }
}
