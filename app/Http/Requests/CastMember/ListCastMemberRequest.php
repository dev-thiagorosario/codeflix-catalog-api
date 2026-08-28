<?php

declare(strict_types=1);

namespace App\Http\Requests\CastMember;

use Illuminate\Foundation\Http\FormRequest;

class ListCastMemberRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->filled('name')) {
            $this->merge([
                'name' => trim((string) $this->input('name')),
            ]);
        }

        if ($this->filled('order')) {
            $this->merge([
                'order' => strtoupper((string) $this->input('order')),
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
            'name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'order' => ['sometimes', 'string', 'in:ASC,DESC'],
        ];
    }
}
