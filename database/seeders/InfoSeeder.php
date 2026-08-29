<?php

namespace Database\Seeders;

use App\Models\Info;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;

class InfoSeeder extends Seeder
{
    public function run(): void
    {
        $infos = [
            [
                'titre' => 'TogoGreenFund - Nouvelle stratégie de financement',
                'contenu' => 'TogoGreenFund lance sa nouvelle stratégie de financement pour la période 2025-2026. Cette stratégie vise à simplifier les procédures et à augmenter le nombre de projets financés.',
                'date' => '2025-01-15',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Appel à projets : Date limite prolongée',
                'contenu' => 'La date limite de dépôt des projets pour la session 2025 est prolongée jusqu\'au 30 avril 2025. Profitez de ce délai supplémentaire pour soumettre vos dossiers.',
                'date' => '2025-02-10',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Nouveau partenariat avec l\'ANADIB',
                'contenu' => 'TogoGreenFund signe un partenariat avec l\'ANADIB pour renforcer l\'accompagnement des porteurs de projets dans les régions rurales du Togo.',
                'date' => '2025-03-05',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Webinaire sur les énergies renouvelables',
                'contenu' => 'Un webinaire sur les opportunités et défis des énergies renouvelables au Togo sera organisé le 15 mai 2025. Inscrivez-vous dès maintenant.',
                'date' => '2025-03-20',
                'etat' => TypeEtat::ACTIF,
            ],
            [
                'titre' => 'Atelier de formation - Lomé',
                'contenu' => 'Un atelier de formation pour les porteurs de projets aura lieu à Lomé le 10 avril 2025. Les places sont limitées. Inscrivez-vous rapidement.',
                'date' => '2025-03-25',
                'etat' => 0, // Inactif
            ],
            [
                'titre' => 'Bilan annuel 2024',
                'contenu' => 'Le bilan annuel 2024 de TogoGreenFund est disponible. 45 projets financés, 2,5 milliards FCFA mobilisés, 1 847 bénéficiaires.',
                'date' => '2025-01-05',
                'etat' => TypeEtat::ACTIF,
            ],
        ];

        foreach ($infos as $info) {
            Info::updateOrCreate(
                ['titre' => $info['titre']],
                $info
            );
        }
    }
}
