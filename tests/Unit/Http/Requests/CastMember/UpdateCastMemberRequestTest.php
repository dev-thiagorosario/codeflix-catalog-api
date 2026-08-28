<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests\CastMember;

use App\Http\Requests\CastMember\UpdateCastMemberRequest;
use Tests\TestCase;

class UpdateCastMemberRequestTest extends TestCase
{
    public function test_it_returns_portuguese_validation_messages(): void
    {
        $request = new UpdateCastMemberRequest;

        $this->assertSame([
            'id.required' => 'O campo id é obrigatório.',
            'id.uuid' => 'O id deve ser um UUID válido.',
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'type.required' => 'O campo tipo é obrigatório.',
            'type.integer' => 'O tipo deve ser um número inteiro.',
            'type.in' => 'O tipo deve ser 1 para diretor ou 2 para ator.',
        ], $request->messages());
    }

    public function test_it_authorizes_request(): void
    {
        $request = new UpdateCastMemberRequest;

        $this->assertTrue($request->authorize());
    }
}
