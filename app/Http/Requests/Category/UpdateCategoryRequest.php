<?php

declare(strict_types=1);

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateCategoryRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->route('id') !== null) {
            $this->merge([
                'id' => $this->route('id'),
            ]);
        }

        if ($this->filled('name')) {
            $this->merge([
                'name' => Str::ucfirst(
                    Str::lower(
                        trim($this->input('name'))
                    )
                ),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'uuid'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O campo id é obrigatório.',
            'id.uuid' => 'O id deve ser um UUID válido.',

            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',

            'description.string' => 'A descrição deve ser uma string.',
            'description.nullable' => 'O campo descrição deve ser nulo.',

            'is_active.boolean' => 'O campo is_active deve ser booleano.',
        ];
    }
}
