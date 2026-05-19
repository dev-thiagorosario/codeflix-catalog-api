<?php

declare(strict_types=1);

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCategoryRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->route('id') !== null) {
            $this->merge([
                'id' => $this->route('id'),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'uuid'],
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
        ];
    }
}
