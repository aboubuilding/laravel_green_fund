<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjetFinanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $projetFinanceId = $this->route('id') ?? $this->input('projet_finance_id');

        return [
            'projet_id' => 'required|exists:projets,id',
            'montant_finance' => 'required|numeric|min:0',
            'partenaire_id' => 'nullable|exists:partenaires,id',
            'annee' => 'nullable|integer|min:2000|max:' . (date('Y') + 1),
            'mise_en_avant' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'projet_id.required' => 'Le projet est obligatoire.',
            'projet_id.exists' => 'Le projet sélectionné n\'existe pas.',
            'montant_finance.required' => 'Le montant financé est obligatoire.',
            'montant_finance.numeric' => 'Le montant doit être un nombre.',
            'montant_finance.min' => 'Le montant doit être supérieur ou égal à 0.',
            'partenaire_id.exists' => 'Le partenaire sélectionné n\'existe pas.',
            'annee.integer' => 'L\'année doit être un nombre entier.',
            'annee.min' => 'L\'année doit être supérieure ou égale à 2000.',
            'annee.max' => 'L\'année doit être inférieure ou égale à ' . (date('Y') + 1) . '.',
            'mise_en_avant.boolean' => 'La mise en avant doit être vrai ou faux.',
        ];
    }

    public function attributes(): array
    {
        return [
            'projet_id' => 'projet',
            'montant_finance' => 'montant financé',
            'partenaire_id' => 'partenaire',
            'annee' => 'année',
            'mise_en_avant' => 'mise en avant',
        ];
    }
}
