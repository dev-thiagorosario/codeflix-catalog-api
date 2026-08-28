<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests\CastMember;

use App\Http\Requests\CastMember\DeleteCastMemberRequest;
use Tests\TestCase;

class DeleteCastMemberRequestTest extends TestCase
{
    public function test_it_returns_portuguese_validation_messages(): void
    {
        $request = new DeleteCastMemberRequest;

        $this->assertSame([
            'id.required' => 'O campo id é obrigatório.',
            'id.uuid' => 'O id deve ser um UUID válido.',
        ], $request->messages());
    }

    public function test_it_authorizes_request(): void
    {
        $request = new DeleteCastMemberRequest;

        $this->assertTrue($request->authorize());
    }
}
