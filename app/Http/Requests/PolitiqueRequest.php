<?php

namespace App\Http\Requests;

use App\Types\TypePolitique;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PolitiqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'titre' => 'required|string|max:255',
            'type_politique_id' => 'required|integer|in:' . implode(',', TypePolitique::values()),
            'date' => 'nullable|date',
            'description' => 'nullable|string',
        ];

        if ($this->isMethod('post')) {
            $rules['fichier'] = 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['fichier'] = 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'type_politique_id.required' => 'Le type de politique est obligatoire.',
            'type_politique_id.in' => 'Le type de politique sélectionné est invalide.',
            'fichier.required' => 'Le fichier est obligatoire.',
            'fichier.file' => 'Le fichier n\'est pas valide.',
            'fichier.max' => 'Le fichier ne peut pas dépasser 10 Mo.',
            'fichier.mimes' => 'Le fichier doit être de type: PDF, DOC, DOCX, XLS, XLSX.',
            'date.date' => 'La date n\'est pas valide.',
        ];
    }

    public function attributes(): array
    {
        return [
            'titre' => 'titre',
            'type_politique_id' => 'type de politique',
            'fichier' => 'fichier',
            'date' => 'date',
            'description' => 'description',
        ];
    }
}
