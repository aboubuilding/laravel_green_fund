<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'titre' => 'required|string|max:255',
            'contenu' => 'nullable|string',
            'date' => 'nullable|date',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'date.date' => 'La date n\'est pas valide.',
        ];
    }

    public function attributes(): array
    {
        return [
            'titre' => 'titre',
            'contenu' => 'contenu',
            'date' => 'date',
        ];
    }
}
