<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests\Genre;

use App\Http\Requests\Genre\CreateGenreRequest;
use Tests\TestCase;

class CreateGenreRequestTest extends TestCase
{
    public function test_it_returns_portuguese_validation_messages(): void
    {
        $request = new CreateGenreRequest;

        $this->assertSame([
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'is_active.boolean' => 'O campo is_active deve ser booleano.',
            'categories_id.array' => 'O campo categories_id deve ser um array.',
            'categories_id.*.required' => 'O id da categoria é obrigatório.',
            'categories_id.*.uuid' => 'O id da categoria deve ser um UUID válido.',
            'categories_id.*.distinct' => 'Os ids das categorias não podem se repetir.',
        ], $request->messages());
    }

    public function test_it_authorizes_request(): void
    {
        $request = new CreateGenreRequest;

        $this->assertTrue($request->authorize());
    }
}
