<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests\Category;

use App\Http\Requests\Category\DeleteCategoryRequest;
use Tests\TestCase;

class DeleteCategoryRequestTest extends TestCase
{
    public function test_it_returns_portuguese_validation_messages(): void
    {
        $request = new DeleteCategoryRequest;

        $this->assertSame([
            'id.required' => 'O campo id é obrigatório.',
            'id.uuid' => 'O id deve ser um UUID válido.',
        ], $request->messages());
    }
}
