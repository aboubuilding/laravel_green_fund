<?php

namespace App\Http\Requests;

use App\Types\Role;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id') ?? $this->input('user_id');

        $rules = [
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'telephone' => 'nullable|string|max:20',
            'role_id' => 'required|in:' . implode(',', Role::values()),
            'est_actif' => 'boolean',
        ];

        // Mot de passe obligatoire pour la création, optionnel pour la modification
        if ($this->isMethod('post')) {
            $rules['mot_de_passe'] = 'required|string|min:8|confirmed';
            $rules['mot_de_passe_confirmation'] = 'required|string|min:8';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['mot_de_passe'] = 'nullable|string|min:8|confirmed';
            $rules['mot_de_passe_confirmation'] = 'nullable|string|min:8';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'role_id.required' => 'Le rôle est obligatoire.',
            'role_id.in' => 'Le rôle sélectionné est invalide.',
            'mot_de_passe.required' => 'Le mot de passe est obligatoire.',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'mot_de_passe.confirmed' => 'Les mots de passe ne correspondent pas.',
            'mot_de_passe_confirmation.required' => 'La confirmation du mot de passe est obligatoire.',
            'est_actif.boolean' => 'Le statut doit être vrai ou faux.',
        ];
    }
}
