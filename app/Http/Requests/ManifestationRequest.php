<?php

namespace App\Http\Requests;

use App\Types\StatutManifestation;
use App\Types\TypeOrganisation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ManifestationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'type_organisation' => 'nullable|integer|in:' . implode(',', TypeOrganisation::values()),
            'guichet_id' => 'nullable|exists:guichets,id',
            'domaine_interet_id' => 'nullable|exists:domaine_interets,id',
            'message' => 'nullable|string',
        ];

        if ($this->isMethod('post')) {
            $rules['document_manifestation'] = 'nullable|file|max:5120|mimes:pdf,doc,docx';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['document_manifestation'] = 'nullable|file|max:5120|mimes:pdf,doc,docx';
            $rules['statut_manifestation'] = ['nullable', Rule::in(StatutManifestation::values())];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'prenom.max' => 'Le prénom ne peut pas dépasser 255 caractères.',
            'email.email' => 'L\'email n\'est pas valide.',
            'email.max' => 'L\'email ne peut pas dépasser 255 caractères.',
            'telephone.max' => 'Le téléphone ne peut pas dépasser 20 caractères.',
            'type_organisation.in' => 'Le type d\'organisation sélectionné est invalide.',
            'guichet_id.exists' => 'Le guichet sélectionné n\'existe pas.',
            'domaine_interet_id.exists' => 'Le domaine d\'intérêt sélectionné n\'existe pas.',
            'document_manifestation.file' => 'Le document n\'est pas valide.',
            'document_manifestation.max' => 'Le document ne peut pas dépasser 5 Mo.',
            'document_manifestation.mimes' => 'Le document doit être de type: PDF, DOC, DOCX.',
            'statut_manifestation.in' => 'Le statut sélectionné est invalide.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nom' => 'nom',
            'prenom' => 'prénom',
            'email' => 'email',
            'telephone' => 'téléphone',
            'type_organisation' => 'type d\'organisation',
            'guichet_id' => 'guichet',
            'domaine_interet_id' => 'domaine d\'intérêt',
            'message' => 'message',
            'document_manifestation' => 'document',
            'statut_manifestation' => 'statut',
        ];
    }
}
