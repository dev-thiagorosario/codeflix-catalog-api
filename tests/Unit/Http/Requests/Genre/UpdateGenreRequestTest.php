<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests\Genre;

use App\Http\Requests\Genre\UpdateGenreRequest;
use Tests\TestCase;

class UpdateGenreRequestTest extends TestCase
{
    public function test_it_returns_portuguese_validation_messages(): void
    {
        $request = new UpdateGenreRequest;

        $this->assertSame([
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
        ], $request->messages());
    }

    public function test_it_authorizes_request(): void
    {
        $request = new UpdateGenreRequest;

        $this->assertTrue($request->authorize());
    }
}
