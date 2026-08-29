<?php

namespace App\Http\Requests;

use App\Types\CategorieDocument;
use App\Types\TypeDocument;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'titre' => 'required|string|max:255',
            'categorie_document' => 'required|integer|in:' . implode(',', CategorieDocument::values()),
            'type' => 'required|string|in:' . implode(',', TypeDocument::values()),
            'date' => 'nullable|date',
            'description' => 'nullable|string',
        ];

        if ($this->isMethod('post')) {
            $rules['fichier'] = 'required|file|max:20480'; // 20MB max
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['fichier'] = 'nullable|file|max:20480';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'categorie_document.required' => 'La catégorie est obligatoire.',
            'categorie_document.in' => 'La catégorie sélectionnée est invalide.',
            'type.required' => 'Le type est obligatoire.',
            'type.in' => 'Le type sélectionné est invalide.',
            'date.date' => 'La date n\'est pas valide.',
            'fichier.required' => 'Le fichier est obligatoire.',
            'fichier.file' => 'Le fichier n\'est pas valide.',
            'fichier.max' => 'Le fichier ne peut pas dépasser 20 Mo.',
        ];
    }

    public function attributes(): array
    {
        return [
            'titre' => 'titre',
            'categorie_document' => 'catégorie',
            'type' => 'type',
            'date' => 'date',
            'fichier' => 'fichier',
            'description' => 'description',
        ];
    }
}
