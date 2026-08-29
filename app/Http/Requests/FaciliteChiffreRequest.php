<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaciliteChiffreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'valeur' => 'required|string|max:255',
            'libelle' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'valeur.required' => 'La valeur est obligatoire.',
            'valeur.max' => 'La valeur ne peut pas dépasser 255 caractères.',
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.max' => 'Le libellé ne peut pas dépasser 255 caractères.',
        ];
    }

    public function attributes(): array
    {
        return [
            'valeur' => 'valeur',
            'libelle' => 'libellé',
        ];
    }
}
