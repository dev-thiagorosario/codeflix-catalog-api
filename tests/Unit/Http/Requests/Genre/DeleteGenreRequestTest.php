<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests\Genre;

use App\Http\Requests\Genre\DeleteGenreRequest;
use Tests\TestCase;

class DeleteGenreRequestTest extends TestCase
{
    public function test_it_returns_portuguese_validation_messages(): void
    {
        $request = new DeleteGenreRequest;

        $this->assertSame([
            'id.required' => 'O campo id é obrigatório.',
            'id.uuid' => 'O id deve ser um UUID válido.',
        ], $request->messages());
    }

    public function test_it_authorizes_request(): void
    {
        $request = new DeleteGenreRequest;

        $this->assertTrue($request->authorize());
    }
}
