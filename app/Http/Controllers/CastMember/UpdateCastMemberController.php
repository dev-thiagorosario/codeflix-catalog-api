<?php

declare(strict_types=1);

namespace App\Http\Controllers\CastMember;

use App\Core\Application\Interfaces\Adapter\CastMember\UpdateCastMemberDataAdapterInterface;
use App\Core\Application\Interfaces\Usecase\CastMember\UpdateCastMemberUsecaseInterface;
use App\Core\Exception\CastMemberNotFoundException;
use App\Core\Exception\UpdateCastMemberException;
use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseJsend;
use App\Http\Requests\CastMember\UpdateCastMemberRequest;
use Illuminate\Http\JsonResponse;

class UpdateCastMemberController extends Controller
{
    public function __construct(
        private readonly UpdateCastMemberUsecaseInterface $usecase,
        private readonly UpdateCastMemberDataAdapterInterface $adapter,
    ) {}

    public function __invoke(UpdateCastMemberRequest $request): JsonResponse
    {
        try {
            $input = $this->adapter->fromArray($request->validated());

            $result = $this->usecase->__invoke($input);

            $response = new ResponseJsend($this->adapter->toArray($result));

            return response()
                ->json($response->toArray(), 200);
        } catch (CastMemberNotFoundException|UpdateCastMemberException $e) {
            $response = new ResponseJsend(
                status: 'error',
                message: $e->getMessage(),
                code: $e->getCode(),
            );

            return response()
                ->json($response->toArray(), 404);
        } catch (\Throwable $e) {
            $response = new ResponseJsend(
                status: 'error',
                message: 'An unexpected error occurred',
                code: 500,
            );

            return response()
                ->json($response->toArray(), 500);
        }
    }
}
