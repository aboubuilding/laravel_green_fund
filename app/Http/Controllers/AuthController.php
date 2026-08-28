<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $result = $this->authService->authenticate(
            $validated['email'],
            $validated['mot_de_passe']
        );

        if ($result['success']) {
            // Connexion avec session Laravel
            auth()->login($result['user'], $request->filled('remember'));

            // Regénérer la session pour sécurité
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'redirect' => $result['redirect'],
                'user' => $result['user'],
            ]);
        }

        return response()->json([
            'success' => false,
            'code' => $result['code'],
            'message' => $result['message'],
        ], 401);
    }

    public function logout(Request $request): JsonResponse
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Déconnexion réussie.',
            'redirect' => route('login'),
        ]);
    }

    public function checkSession(): JsonResponse
    {
        $user = auth()->user();

        return response()->json([
            'authenticated' => !is_null($user),
            'user' => $user,
        ]);
    }
}
