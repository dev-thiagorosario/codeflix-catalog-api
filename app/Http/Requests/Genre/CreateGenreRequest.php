<?php

declare(strict_types=1);

namespace App\Http\Requests\Genre;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreateGenreRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
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
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
            'categories_id' => ['sometimes', 'array'],
            'categories_id.*' => ['required', 'uuid', 'distinct'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',

            'is_active.boolean' => 'O campo is_active deve ser booleano.',

            'categories_id.array' => 'O campo categories_id deve ser um array.',
            'categories_id.*.required' => 'O id da categoria é obrigatório.',
            'categories_id.*.uuid' => 'O id da categoria deve ser um UUID válido.',
            'categories_id.*.distinct' => 'Os ids das categorias não podem se repetir.',
        ];
    }
}
