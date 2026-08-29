<?php

namespace App\Http\Requests;

use App\Types\TypeEvenement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EvenementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_evenement' => 'nullable|date|after_or_equal:today',
            'lieu' => 'nullable|string|max:255',
            'type_evenement' => 'required|integer|in:' . implode(',', TypeEvenement::values()),
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
            'type_evenement.required' => 'Le type d\'événement est obligatoire.',
            'type_evenement.in' => 'Le type d\'événement sélectionné est invalide.',
            'date_evenement.date' => 'La date n\'est pas valide.',
            'date_evenement.after_or_equal' => 'La date doit être aujourd\'hui ou dans le futur.',
            'lieu.max' => 'Le lieu ne peut pas dépasser 255 caractères.',
            'image.image' => 'Le fichier doit être une image.',
            'image.max' => 'L\'image ne peut pas dépasser 2 Mo.',
            'image.mimes' => 'L\'image doit être de type: JPEG, PNG, JPG, GIF, WEBP.',
        ];
    }

    public function attributes(): array
    {
        return [
            'titre' => 'titre',
            'description' => 'description',
            'date_evenement' => 'date',
            'lieu' => 'lieu',
            'type_evenement' => 'type',
            'image' => 'image',
        ];
    }
}
