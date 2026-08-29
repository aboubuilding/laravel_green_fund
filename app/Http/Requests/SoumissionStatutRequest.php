<?php

namespace App\Http\Requests;

use App\Types\StatutSoumission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SoumissionStatutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'statut' => 'required|integer|in:' . implode(',', StatutSoumission::values()),
            'commentaire' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'statut.required' => 'Le statut est obligatoire.',
            'statut.in' => 'Le statut sélectionné est invalide.',
        ];
    }

    public function attributes(): array
    {
        return [
            'statut' => 'statut',
            'commentaire' => 'commentaire',
        ];
    }
}
