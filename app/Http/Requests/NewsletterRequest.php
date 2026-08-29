<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsletterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $newsletterId = $this->route('id') ?? $this->input('newsletter_id');

        $rules = [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('newsletters', 'email')->where(function ($query) {
                    return $query->where('etat', TypeEtat::ACTIF);
                })->ignore($newsletterId),
            ],
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà inscrite.',
            'email.max' => 'L\'adresse email ne peut pas dépasser 255 caractères.',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'adresse email',
        ];
    }
}
