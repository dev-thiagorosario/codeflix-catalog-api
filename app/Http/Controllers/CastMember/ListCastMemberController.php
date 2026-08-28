<?php

declare(strict_types=1);

namespace App\Http\Controllers\CastMember;

use App\Core\Application\Interfaces\Adapter\CastMember\ListCastMembersDataAdapterInterface;
use App\Core\Application\Interfaces\Usecase\CastMember\ListCastMembersUsecaseInterface;
use App\Core\Exception\ListCastMemberException;
use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseJsend;
use App\Http\Requests\CastMember\ListCastMemberRequest;
use Illuminate\Http\JsonResponse;

class ListCastMemberController extends Controller
{
    public function __construct(
        private readonly ListCastMembersUsecaseInterface $usecase,
        private readonly ListCastMembersDataAdapterInterface $adapter,
    ) {}

    public function __invoke(ListCastMemberRequest $request): JsonResponse
    {
        try {
            $input = $this->adapter->fromArray($request->validated());

            $result = $this->usecase->__invoke($input);

            $response = new ResponseJsend($this->adapter->toArray($result));

            return response()
                ->json($response->toArray(), 200);
        } catch (ListCastMemberException $e) {
            $response = new ResponseJsend(
                status: 'error',
                message: $e->getMessage(),
                code: $e->getCode(),
            );

            return response()
                ->json($response->toArray(), 400);
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
