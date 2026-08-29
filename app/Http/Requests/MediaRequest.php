<?php

namespace App\Http\Requests;

use App\Types\TypeMedia;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'type_media' => 'required|integer|in:' . implode(',', TypeMedia::values()),
            'description' => 'nullable|string',
            'date' => 'nullable|date',
        ];

        if ($this->isMethod('post')) {
            $rules['fichier'] = 'required|file|max:51200|mimes:jpeg,png,jpg,gif,webp,mp4,avi,mov,wmv';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['fichier'] = 'nullable|file|max:51200|mimes:jpeg,png,jpg,gif,webp,mp4,avi,mov,wmv';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'type_media.required' => 'Le type de média est obligatoire.',
            'type_media.in' => 'Le type de média sélectionné est invalide.',
            'fichier.required' => 'Le fichier est obligatoire.',
            'fichier.file' => 'Le fichier n\'est pas valide.',
            'fichier.max' => 'Le fichier ne peut pas dépasser 50 Mo.',
            'fichier.mimes' => 'Le fichier doit être de type: jpeg, png, jpg, gif, webp, mp4, avi, mov, wmv.',
            'date.date' => 'La date n\'est pas valide.',
        ];
    }

    public function attributes(): array
    {
        return [
            'type_media' => 'type de média',
            'fichier' => 'fichier',
            'description' => 'description',
            'date' => 'date',
        ];
    }
}
