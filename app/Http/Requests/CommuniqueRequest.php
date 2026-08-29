<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommuniqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'titre' => 'required|string|max:255',
            'date_publication' => 'nullable|date',
            'resume' => 'nullable|string',
        ];

        if ($this->isMethod('post')) {
            $rules['document'] = 'required|file|max:5120|mimes:pdf';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['document'] = 'nullable|file|max:5120|mimes:pdf';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'document.required' => 'Le document PDF est obligatoire.',
            'document.file' => 'Le document n\'est pas valide.',
            'document.max' => 'Le document ne peut pas dépasser 5 Mo.',
            'document.mimes' => 'Le document doit être au format PDF.',
            'date_publication.date' => 'La date de publication n\'est pas valide.',
        ];
    }

    public function attributes(): array
    {
        return [
            'titre' => 'titre',
            'document' => 'document PDF',
            'date_publication' => 'date de publication',
            'resume' => 'résumé',
        ];
    }
}
