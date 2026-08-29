<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsletterCampaignRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sujet' => 'required|string|max:255',
            'contenu' => 'required|string',
            'destinataires' => 'required|in:tous,actifs',
        ];
    }

    public function messages(): array
    {
        return [
            'sujet.required' => 'Le sujet est obligatoire.',
            'sujet.max' => 'Le sujet ne peut pas dépasser 255 caractères.',
            'contenu.required' => 'Le contenu est obligatoire.',
            'destinataires.required' => 'Veuillez sélectionner les destinataires.',
            'destinataires.in' => 'Le choix des destinataires est invalide.',
        ];
    }

    public function attributes(): array
    {
        return [
            'sujet' => 'sujet',
            'contenu' => 'contenu',
            'destinataires' => 'destinataires',
        ];
    }
}
