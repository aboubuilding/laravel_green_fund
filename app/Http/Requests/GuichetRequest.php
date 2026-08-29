<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuichetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $guichetId = $this->route('id') ?? $this->input('guichet_id');

        return [
            'nom' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('guichets', 'slug')->ignore($guichetId),
            ],
            'description' => 'nullable|string',
            'icone' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'slug.unique' => 'Ce slug est déjà utilisé.',
            'icone.max' => 'L\'icône ne peut pas dépasser 100 caractères.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nom' => 'nom',
            'slug' => 'slug',
            'description' => 'description',
            'icone' => 'icône',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('nom') && !$this->has('slug')) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->nom),
            ]);
        }
    }
}
