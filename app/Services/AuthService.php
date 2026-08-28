<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Authentifier un utilisateur
     */
    public function authenticate(string $email, string $password): array
    {
        $user = $this->userRepository->findActiveByEmail($email);

        if (!$user) {
            return [
                'success' => false,
                'code' => 'USER_NOT_FOUND',
                'message' => 'Aucun compte ne correspond à cet email.',
            ];
        }

        if (!Hash::check($password, $user->mot_de_passe)) {
            return [
                'success' => false,
                'code' => 'INVALID_PASSWORD',
                'message' => 'Le mot de passe saisi est incorrect.',
            ];
        }

        if (!$user->canLogin()) {
            return [
                'success' => false,
                'code' => 'ACCOUNT_INACTIVE',
                'message' => 'Votre compte a été désactivé. Contactez l\'administrateur.',
            ];
        }

        // Mettre à jour la date de dernière connexion
        $this->userRepository->updateLastLogin($user->id);

        // Connexion avec session Laravel (pas de token)
        return [
            'success' => true,
            'user' => $user,
            'message' => 'Connexion réussie !',
            'redirect' => route('dashboard'),
        ];
    }

    /**
     * Vérifier l'état de la session
     */
    public function checkSession(): array
    {
        $user = auth()->user();

        if ($user) {
            return [
                'authenticated' => true,
                'user' => $user,
            ];
        }

        return [
            'authenticated' => false,
        ];
    }
}
