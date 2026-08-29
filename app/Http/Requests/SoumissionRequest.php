<?php

namespace App\Http\Requests;

use App\Types\StatutSoumission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SoumissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $soumissionId = $this->route('id') ?? $this->input('soumission_id');

        $rules = [
            'type_porteur' => 'nullable|integer',
            'porteur_nom' => 'required|string|max:255',
            'porteur_fonction' => 'required|string|max:255',
            'porteur_email' => 'required|email|max:255',
            'porteur_telephone' => 'nullable|string|max:20',
            'titre_projet' => 'required|string|max:255',
            'guichet_id' => 'nullable|exists:guichets,id',
            'region_id' => 'nullable|exists:regions,id',
            'prefecture_id' => 'nullable|exists:prefectures,id',
            'commune_id' => 'nullable|exists:communes,id',
            'montant_sollicite' => 'nullable|numeric|min:0',
            'cout_global' => 'nullable|numeric|min:0',
            'resume_projet' => 'nullable|string',
            'objet_projet' => 'nullable|string',
            'date_demarrage' => 'nullable|date',
            'duree_envisagee' => 'nullable|integer',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['statut_soumission'] = ['nullable', Rule::in(StatutSoumission::values())];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'porteur_nom.required' => 'Le nom du porteur est obligatoire.',
            'porteur_fonction.required' => 'La fonction du porteur est obligatoire.',
            'porteur_email.required' => 'L\'email du porteur est obligatoire.',
            'porteur_email.email' => 'L\'email du porteur n\'est pas valide.',
            'titre_projet.required' => 'Le titre du projet est obligatoire.',
            'guichet_id.exists' => 'Le guichet sélectionné n\'existe pas.',
            'region_id.exists' => 'La région sélectionnée n\'existe pas.',
            'prefecture_id.exists' => 'La préfecture sélectionnée n\'existe pas.',
            'commune_id.exists' => 'La commune sélectionnée n\'existe pas.',
            'montant_sollicite.numeric' => 'Le montant sollicité doit être un nombre.',
            'cout_global.numeric' => 'Le coût global doit être un nombre.',
            'statut_soumission.in' => 'Le statut sélectionné est invalide.',
            'date_demarrage.date' => 'La date de démarrage n\'est pas valide.',
        ];
    }

    public function attributes(): array
    {
        return [
            'type_porteur' => 'type de porteur',
            'porteur_nom' => 'nom du porteur',
            'porteur_fonction' => 'fonction du porteur',
            'porteur_email' => 'email du porteur',
            'porteur_telephone' => 'téléphone du porteur',
            'titre_projet' => 'titre du projet',
            'guichet_id' => 'guichet',
            'region_id' => 'région',
            'prefecture_id' => 'préfecture',
            'commune_id' => 'commune',
            'montant_sollicite' => 'montant sollicité',
            'cout_global' => 'coût global',
            'statut_soumission' => 'statut',
        ];
    }
}
