<?php

declare(strict_types=1);

namespace App\Http\Requests\Genre;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateGenreRequest extends FormRequest
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
            'is_active' => ['sometimes', 'boolean'],
            'categories_id_to_add' => ['sometimes', 'array'],
            'categories_id_to_add.*' => ['required', 'uuid', 'distinct'],
            'categories_id_to_remove' => ['sometimes', 'array'],
            'categories_id_to_remove.*' => ['required', 'uuid', 'distinct'],
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

            'is_active.boolean' => 'O campo is_active deve ser booleano.',

            'categories_id_to_add.array' => 'O campo categories_id_to_add deve ser um array.',
            'categories_id_to_add.*.required' => 'O id da categoria é obrigatório.',
            'categories_id_to_add.*.uuid' => 'O id da categoria deve ser um UUID válido.',
            'categories_id_to_add.*.distinct' => 'Os ids das categorias não podem se repetir.',

            'categories_id_to_remove.array' => 'O campo categories_id_to_remove deve ser um array.',
            'categories_id_to_remove.*.required' => 'O id da categoria é obrigatório.',
            'categories_id_to_remove.*.uuid' => 'O id da categoria deve ser um UUID válido.',
            'categories_id_to_remove.*.distinct' => 'Os ids das categorias não podem se repetir.',
        ];
    }
}
