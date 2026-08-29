<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaciliteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $faciliteId = $this->route('id') ?? $this->input('facilite_id');

        return [
            'nom' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('facilites', 'slug')->ignore($faciliteId),
            ],
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'slug.unique' => 'Ce slug est déjà utilisé.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nom' => 'nom',
            'slug' => 'slug',
            'description' => 'description',
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
