<?php

namespace Database\Seeders;

use App\Models\ProjetFinance;
use App\Models\Projet;
use App\Models\Partenaire;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;

class ProjetFinanceSeeder extends Seeder
{
    public function run(): void
    {
        $projets = Projet::where('etat', TypeEtat::ACTIF)->get();
        $partenaires = Partenaire::where('etat', TypeEtat::ACTIF)->get();

        $projetFinances = [
            [
                'projet_id' => $projets->first()?->id,
                'montant_finance' => 15500000,
                'partenaire_id' => $partenaires->first()?->id,
                'annee' => 2025,
                'mise_en_avant' => true,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'projet_id' => $projets->skip(1)->first()?->id,
                'montant_finance' => 22000000,
                'partenaire_id' => $partenaires->skip(1)->first()?->id,
                'annee' => 2025,
                'mise_en_avant' => false,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'projet_id' => $projets->skip(2)->first()?->id,
                'montant_finance' => 8750000,
                'partenaire_id' => $partenaires->skip(2)->first()?->id,
                'annee' => 2024,
                'mise_en_avant' => true,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'projet_id' => $projets->skip(3)->first()?->id,
                'montant_finance' => 45000000,
                'partenaire_id' => $partenaires->skip(3)->first()?->id,
                'annee' => 2025,
                'mise_en_avant' => false,
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'projet_id' => $projets->skip(4)->first()?->id,
                'montant_finance' => 18200000,
                'partenaire_id' => $partenaires->skip(4)->first()?->id,
                'annee' => 2024,
                'mise_en_avant' => false,
                'etat' => TypeEtat::ACTIF,
            ],
        ];

        foreach ($projetFinances as $projetFinance) {
            ProjetFinance::updateOrCreate(
                [
                    'projet_id' => $projetFinance['projet_id'],
                    'annee' => $projetFinance['annee'],
                ],
                $projetFinance
            );
        }
    }
}
