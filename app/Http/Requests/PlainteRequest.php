<?php

namespace App\Http\Requests;

use App\Types\StatutPlainte;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlainteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'nom' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'objet' => 'required|string|max:255',
            'description' => 'required|string',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['statut'] = ['nullable', Rule::in(StatutPlainte::values())];
            $rules['reponse'] = 'nullable|string';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'email.email' => 'L\'email n\'est pas valide.',
            'email.max' => 'L\'email ne peut pas dépasser 255 caractères.',
            'telephone.max' => 'Le téléphone ne peut pas dépasser 20 caractères.',
            'objet.required' => 'L\'objet est obligatoire.',
            'objet.max' => 'L\'objet ne peut pas dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'statut.in' => 'Le statut sélectionné est invalide.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nom' => 'nom',
            'email' => 'email',
            'telephone' => 'téléphone',
            'objet' => 'objet',
            'description' => 'description',
            'statut' => 'statut',
            'reponse' => 'réponse',
        ];
    }
}
