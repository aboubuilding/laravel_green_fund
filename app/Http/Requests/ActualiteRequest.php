<?php

namespace App\Http\Requests;

use App\Types\StatutActualite;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActualiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $actualiteId = $this->route('id') ?? $this->input('actualite_id');

        $rules = [
            'titre' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('actualites', 'slug')->ignore($actualiteId),
            ],
            'contenu' => 'required|string',
            'extrait' => 'nullable|string',
            'statut_actualite' => 'required|integer|in:' . implode(',', StatutActualite::values()),
            'date_publication' => 'nullable|date|after_or_equal:today',
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
            'contenu.required' => 'Le contenu est obligatoire.',
            'statut_actualite.required' => 'Le statut est obligatoire.',
            'statut_actualite.in' => 'Le statut sélectionné est invalide.',
            'image.image' => 'Le fichier doit être une image.',
            'image.max' => 'L\'image ne peut pas dépasser 2 Mo.',
            'image.mimes' => 'L\'image doit être de type: JPEG, PNG, JPG, GIF, WEBP.',
            'date_publication.date' => 'La date de publication n\'est pas valide.',
            'date_publication.after_or_equal' => 'La date de publication doit être aujourd\'hui ou dans le futur.',
        ];
    }

    public function attributes(): array
    {
        return [
            'titre' => 'titre',
            'slug' => 'slug',
            'contenu' => 'contenu',
            'extrait' => 'extrait',
            'image' => 'image',
            'statut_actualite' => 'statut',
            'date_publication' => 'date de publication',
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
