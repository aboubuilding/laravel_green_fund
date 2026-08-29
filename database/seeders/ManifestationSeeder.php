<?php

namespace Database\Seeders;

use App\Models\Manifestation;
use App\Models\Guichet;
use App\Models\DomaineInteret;
use App\Types\StatutManifestation;
use App\Types\TypeOrganisation;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;

class ManifestationSeeder extends Seeder
{
    public function run(): void
    {
        $guichets = Guichet::where('etat', TypeEtat::ACTIF)->get();
        $domaines = DomaineInteret::where('etat', TypeEtat::ACTIF)->get();

        $manifestations = [
            [
                'nom' => 'Komi',
                'prenom' => 'Jean',
                'email' => 'jean.komi@example.com',
                'type_organisation' => TypeOrganisation::ENTREPRISE_PRIVEE,
                'telephone' => '+228 90000020',
                'guichet_id' => $guichets->first()?->id,
                'domaine_interet_id' => $domaines->first()?->id,
                'message' => 'Je suis intéressé par le financement d\'un projet d\'installation solaire pour ma ferme agricole.',
                'document_manifestation' => null,
                'statut_manifestation' => StatutManifestation::NOUVEAU,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Abalo',
                'prenom' => 'Marie',
                'email' => 'marie.abalo@example.com',
                'type_organisation' => TypeOrganisation::ASSOCIATION_ONG,
                'telephone' => '+228 90000021',
                'guichet_id' => $guichets->skip(1)->first()?->id,
                'domaine_interet_id' => $domaines->skip(1)->first()?->id,
                'message' => 'Nous souhaitons soumettre un projet de forage d\'eau potable pour 3 villages.',
                'document_manifestation' => null,
                'statut_manifestation' => StatutManifestation::NOUVEAU,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Adjei',
                'prenom' => 'Pierre',
                'email' => 'pierre.adjei@example.com',
                'type_organisation' => TypeOrganisation::GROUPEMENT_PRODUCTION,
                'telephone' => '+228 90000022',
                'guichet_id' => $guichets->skip(2)->first()?->id,
                'domaine_interet_id' => $domaines->skip(2)->first()?->id,
                'message' => 'Projet d\'agroforesterie pour la plantation de 10 000 arbres fruitiers.',
                'document_manifestation' => null,
                'statut_manifestation' => StatutManifestation::TRAITE,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Tchagba',
                'prenom' => 'Afi',
                'email' => 'afi.tchagba@example.com',
                'type_organisation' => TypeOrganisation::INSTITUTION_PUBLIQUE,
                'telephone' => '+228 90000023',
                'guichet_id' => $guichets->skip(3)->first()?->id,
                'domaine_interet_id' => $domaines->skip(3)->first()?->id,
                'message' => 'Projet de reforestation de la forêt classée de la région.',
                'document_manifestation' => null,
                'statut_manifestation' => StatutManifestation::NOUVEAU,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'nom' => 'Akakpo',
                'prenom' => 'Kossi',
                'email' => 'kossi.akakpo@example.com',
                'type_organisation' => TypeOrganisation::ENTREPRISE_PRIVEE,
                'telephone' => '+228 90000024',
                'guichet_id' => $guichets->skip(4)->first()?->id,
                'domaine_interet_id' => $domaines->skip(4)->first()?->id,
                'message' => 'Installation de micro-réseaux solaires pour 5 villages.',
                'document_manifestation' => null,
                'statut_manifestation' => StatutManifestation::TRAITE,
                'etat' => TypeEtat::ACTIF,
            ],
        ];

        foreach ($manifestations as $manifestation) {
            Manifestation::updateOrCreate(
                [
                    'email' => $manifestation['email'],
                    'nom' => $manifestation['nom'],
                ],
                $manifestation
            );
        }
    }
}
