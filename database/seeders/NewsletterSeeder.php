<?php

namespace Database\Seeders;

use App\Models\Newsletter;
use App\Types\StatutNewsletter;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;

class NewsletterSeeder extends Seeder
{
    public function run(): void
    {
        $subscribers = [
            [
                'email' => 'jean.dupont@example.com',
                'statut' => StatutNewsletter::ACTIF,
                'date_inscription' => now()->subDays(5),
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'email' => 'marie.kouassi@example.com',
                'statut' => StatutNewsletter::ACTIF,
                'date_inscription' => now()->subDays(10),
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'email' => 'pierre.yao@example.com',
                'statut' => StatutNewsletter::ACTIF,
                'date_inscription' => now()->subDays(15),
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'email' => 'fatima.diallo@example.com',
                'statut' => StatutNewsletter::DESABONNE,
                'date_inscription' => now()->subDays(20),
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'email' => 'mohamed.tchacondoh@example.com',
                'statut' => StatutNewsletter::ACTIF,
                'date_inscription' => now()->subDays(8),
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'email' => 'koffi.mensah@example.com',
                'statut' => StatutNewsletter::ACTIF,
                'date_inscription' => now()->subDays(12),
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'email' => 'afi.tchagba@example.com',
                'statut' => StatutNewsletter::DESABONNE,
                'date_inscription' => now()->subDays(25),
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'email' => 'yao.adjei@example.com',
                'statut' => StatutNewsletter::ACTIF,
                'date_inscription' => now()->subDays(3),
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'email' => 'togbe.dosseh@example.com',
                'statut' => StatutNewsletter::ACTIF,
                'date_inscription' => now()->subDays(7),
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'email' => 'kossi.akakpo@example.com',
                'statut' => StatutNewsletter::ACTIF,
                'date_inscription' => now()->subDays(1),
                'etat' => TypeEtat::ACTIF,
            ],
        ];

        foreach ($subscribers as $subscriber) {
            Newsletter::updateOrCreate(
                ['email' => $subscriber['email']],
                $subscriber
            );
        }
    }
}
