<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests\CastMember;

use App\Http\Requests\CastMember\ListCastMemberRequest;
use Tests\TestCase;

class ListCastMemberRequestTest extends TestCase
{
    public function test_it_returns_validation_rules(): void
    {
        $request = new ListCastMemberRequest;

        $this->assertSame([
            'name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'order' => ['sometimes', 'string', 'in:ASC,DESC'],
        ], $request->rules());
    }

    public function test_it_authorizes_request(): void
    {
        $request = new ListCastMemberRequest;

        $this->assertTrue($request->authorize());
    }
}
