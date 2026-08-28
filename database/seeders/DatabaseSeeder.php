<?php

namespace Database\Seeders;

use App\Models\User;
use App\Types\Role;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@togogreenfund.tg'],
            [
                'role_id' => Role::ADMIN,
                'nom' => 'Administrateur',
                'email' => 'admin@togogreenfund.tg',
                'telephone' => '+228 90000000',
                'avatar' => null,
                'email_verifie_le' => now(),
                'mot_de_passe' => Hash::make('password'),
                'est_actif' => true,
                'derniere_connexion_le' => now(),
                'etat' => TypeEtat::ACTIF,
            ]
        );

        // Utilisateur 1
        User::updateOrCreate(
            ['email' => 'jean.dupont@example.com'],
            [
                'role_id' => Role::USER,
                'nom' => 'Jean Dupont',
                'email' => 'jean.dupont@example.com',
                'telephone' => '+228 90000001',
                'avatar' => null,
                'email_verifie_le' => now(),
                'mot_de_passe' => Hash::make('password'),
                'est_actif' => true,
                'derniere_connexion_le' => now()->subDays(2),
                'etat' => TypeEtat::ACTIF,
            ]
        );

        // Utilisateur 2
        User::updateOrCreate(
            ['email' => 'marie.kouassi@example.com'],
            [
                'role_id' => Role::USER,
                'nom' => 'Marie Kouassi',
                'email' => 'marie.kouassi@example.com',
                'telephone' => '+228 90000002',
                'avatar' => null,
                'email_verifie_le' => now()->subDays(5),
                'mot_de_passe' => Hash::make('password'),
                'est_actif' => true,
                'derniere_connexion_le' => now()->subDays(10),
                'etat' => TypeEtat::ACTIF,
            ]
        );
    }
}
