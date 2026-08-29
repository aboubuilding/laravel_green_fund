<?php

namespace App\Http\Requests;

use App\Types\StatutProjet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $projetId = $this->route('id') ?? $this->input('projet_id');

        $rules = [
            'titre' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('projets', 'slug')->ignore($projetId),
            ],
            'description' => 'nullable|string',
            'statut_projet' => 'required|integer|in:' . implode(',', StatutProjet::values()),
            'type_projet_id' => 'nullable|exists:type_projets,id',
            'region_id' => 'nullable|exists:regions,id',
            'prefecture_id' => 'nullable|exists:prefectures,id',
            'commune_id' => 'nullable|exists:communes,id',
            'budget' => 'nullable|numeric|min:0',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif,webp';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['image'] = 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif,webp';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'slug.unique' => 'Ce slug est déjà utilisé.',
            'statut_projet.required' => 'Le statut est obligatoire.',
            'statut_projet.in' => 'Le statut sélectionné est invalide.',
            'type_projet_id.exists' => 'Le type de projet sélectionné n\'existe pas.',
            'region_id.exists' => 'La région sélectionnée n\'existe pas.',
            'prefecture_id.exists' => 'La préfecture sélectionnée n\'existe pas.',
            'commune_id.exists' => 'La commune sélectionnée n\'existe pas.',
            'budget.numeric' => 'Le budget doit être un nombre.',
            'budget.min' => 'Le budget doit être supérieur ou égal à 0.',
            'date_debut.date' => 'La date de début n\'est pas valide.',
            'date_fin.date' => 'La date de fin n\'est pas valide.',
            'date_fin.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
            'image.image' => 'Le fichier doit être une image.',
            'image.max' => 'L\'image ne peut pas dépasser 2 Mo.',
            'image.mimes' => 'L\'image doit être de type: JPEG, PNG, JPG, GIF, WEBP.',
        ];
    }

    public function attributes(): array
    {
        return [
            'titre' => 'titre',
            'slug' => 'slug',
            'description' => 'description',
            'image' => 'image',
            'statut_projet' => 'statut',
            'type_projet_id' => 'type de projet',
            'region_id' => 'région',
            'prefecture_id' => 'préfecture',
            'commune_id' => 'commune',
            'budget' => 'budget',
            'date_debut' => 'date de début',
            'date_fin' => 'date de fin',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('titre') && !$this->has('slug')) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->titre),
            ]);
        }
    }
}
