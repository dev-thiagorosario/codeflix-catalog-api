<?php

declare(strict_types=1);

namespace App\Http\Controllers\CastMember;

use App\Core\Application\DTO\CastMember\DeleteCastMemberInputDTO;
use App\Core\Application\Interfaces\Usecase\CastMember\DeleteCastMemberUsecaseInterface;
use App\Core\Exception\CastMemberNotFoundException;
use App\Core\Exception\DeleteCastMemberException;
use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseJsend;
use App\Http\Requests\CastMember\DeleteCastMemberRequest;
use Illuminate\Http\JsonResponse;

class DeleteCastMemberController extends Controller
{
    public function __construct(
        private readonly DeleteCastMemberUsecaseInterface $usecase,
    ) {}

    public function __invoke(DeleteCastMemberRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $input = new DeleteCastMemberInputDTO(
                id: $validated['id'],
            );

            $this->usecase->__invoke($input);

            $response = new ResponseJsend;

            return response()
                ->json($response->toArray(), 200);
        } catch (CastMemberNotFoundException|DeleteCastMemberException $e) {
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
