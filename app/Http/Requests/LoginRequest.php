<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'mot_de_passe' => 'required|string|min:6|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'email.max' => 'L\'adresse email ne peut pas dépasser 255 caractères.',
            'mot_de_passe.required' => 'Le mot de passe est obligatoire.',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
            'mot_de_passe.max' => 'Le mot de passe ne peut pas dépasser 255 caractères.',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'adresse email',
            'mot_de_passe' => 'mot de passe',
        ];
    }
}
