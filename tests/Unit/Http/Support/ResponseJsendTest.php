<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Support;

use App\Core\Exception\InvalidJsendStatusException;
use App\Core\Exception\JsendErrorMessageRequiredException;
use App\Http\Support\ResponseJsend;
use Tests\TestCase;

class ResponseJsendTest extends TestCase
{
    public function test_create_success_response_from_controller_data(): void
    {
        $data = [
            'id' => 'category-id',
            'name' => 'Movies',
        ];

        $response = new ResponseJsend($data);

        $this->assertSame([
            'status' => 'success',
            'data' => $data,
        ], $response->toArray());
    }

    public function test_create_error_response(): void
    {
        $response = new ResponseJsend(
            data: [],
            status: 'error',
            message: 'Categoria nao encontrada',
            code: 404
        );

        $this->assertSame([
            'status' => 'error',
            'data' => [],
            'message' => 'Categoria nao encontrada',
            'code' => 404,
        ], $response->toArray());
    }

    public function test_can_be_used_directly_as_json_serializable(): void
    {
        $response = new ResponseJsend(['name' => 'Movies']);

        $this->assertSame('{"status":"success","data":{"name":"Movies"}}', json_encode($response));
    }

    public function test_can_create_laravel_json_response(): void
    {
        $response = new ResponseJsend(['id' => 'category-id']);

        $jsonResponse = $response->toJsonResponse(201);

        $this->assertSame(201, $jsonResponse->getStatusCode());
        $this->assertSame([
            'status' => 'success',
            'data' => [
                'id' => 'category-id',
            ],
        ], $jsonResponse->getData(true));
    }

    public function test_rejects_invalid_status(): void
    {
        $this->expectException(InvalidJsendStatusException::class);
        $this->expectExceptionMessage('Invalid JSend status [invalid].');

        new ResponseJsend(status: 'invalid');
    }

    public function test_error_response_requires_message(): void
    {
        $this->expectException(JsendErrorMessageRequiredException::class);
        $this->expectExceptionMessage('JSend error responses require a message.');

        new ResponseJsend(status: ResponseJsend::STATUS_ERROR);
    }
}
