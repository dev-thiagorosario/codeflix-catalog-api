<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests\Category;

use App\Http\Requests\Category\CreateCategoryRequest;
use Tests\TestCase;

class CreateCategoryRequestTest extends TestCase
{
    public function test_it_returns_portuguese_validation_messages(): void
    {
        $request = new CreateCategoryRequest;

        $this->assertSame([
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'description.string' => 'A descrição deve ser uma string.',
            'description.max' => 'A descrição não pode ter mais de 255 caracteres.',
            'description.nullable' => 'O campo descrição deve ser nulo.',
            'is_active.boolean' => 'O campo is_active deve ser booleano.',
        ], $request->messages());
    }
}
