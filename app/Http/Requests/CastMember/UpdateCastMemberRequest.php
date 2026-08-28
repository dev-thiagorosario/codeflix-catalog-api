<?php

declare(strict_types=1);

namespace App\Http\Requests\CastMember;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCastMemberRequest extends FormRequest
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
                'name' => trim((string) $this->input('name')),
            ]);
        }
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'uuid'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'integer', 'in:1,2'],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O campo id é obrigatório.',
            'id.uuid' => 'O id deve ser um UUID válido.',

            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',

            'type.required' => 'O campo tipo é obrigatório.',
            'type.integer' => 'O tipo deve ser um número inteiro.',
            'type.in' => 'O tipo deve ser 1 para diretor ou 2 para ator.',
        ];
    }
}
