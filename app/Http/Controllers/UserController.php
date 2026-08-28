<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use App\Types\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Liste des utilisateurs
     */
    public function index()
    {
        $users = $this->userService->getAll();
        $stats = $this->userService->getStats();
        $roles = Role::list();

        return view('users.index', compact('users', 'stats', 'roles'));
    }

    /**
     * Créer un utilisateur
     */
    public function store(UserRequest $request)
    {
        try {
            $this->userService->create($request->validated());

            return redirect()
                ->route('users.index')
                ->with('success', 'Utilisateur créé avec succès.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(UserRequest $request, int $id)
    {
        try {
            $this->userService->update($id, $request->validated());

            return redirect()
                ->route('users.index')
                ->with('success', 'Utilisateur mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy(int $id)
    {
        try {
            $this->userService->delete($id);

            return redirect()
                ->route('users.index')
                ->with('success', 'Utilisateur supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    /**
     * Activer/Désactiver un utilisateur
     */
    public function toggleStatus(int $id)
    {
        try {
            $this->userService->toggleStatus($id);

            return redirect()
                ->route('users.index')
                ->with('success', 'Statut de l\'utilisateur mis à jour.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erreur lors de la mise à jour du statut.');
        }
    }
}
