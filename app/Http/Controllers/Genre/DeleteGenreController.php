<?php

declare(strict_types=1);

namespace App\Http\Controllers\Genre;

use App\Core\Application\DTO\Genre\DeleteGenreInputDTO;
use App\Core\Application\Interfaces\Usecase\Genre\DeleteGenreUsecaseInterface;
use App\Core\Exception\DeleteGenreException;
use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseJsend;
use App\Http\Requests\Genre\DeleteGenreRequest;
use Illuminate\Http\JsonResponse;

class DeleteGenreController extends Controller
{
    public function __construct(
        private readonly DeleteGenreUsecaseInterface $usecase,
    ) {}

    public function __invoke(DeleteGenreRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $input = new DeleteGenreInputDTO(
                id: $validated['id'],
            );

            $this->usecase->__invoke($input);

            $response = new ResponseJsend;

            return response()
                ->json($response->toArray(), 200);
        } catch (DeleteGenreException $e) {
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
