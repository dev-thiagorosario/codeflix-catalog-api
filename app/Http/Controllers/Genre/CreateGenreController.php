<?php

declare(strict_types=1);

namespace App\Http\Controllers\Genre;

use App\Core\Application\Interfaces\Adapter\Genre\CreateGenreDataAdapterInterface;
use App\Core\Application\Interfaces\Usecase\Genre\CreateGenreUsecaseInterface;
use App\Core\Exception\CreateGenreException;
use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseJsend;
use App\Http\Requests\Genre\CreateGenreRequest;
use Illuminate\Http\JsonResponse;

class CreateGenreController extends Controller
{
    public function __construct(
        private readonly CreateGenreUsecaseInterface $usecase,
        private readonly CreateGenreDataAdapterInterface $adapter,
    ) {}

    public function __invoke(CreateGenreRequest $request): JsonResponse
    {
        try {
            $input = $this->adapter->fromArray($request->validated());

            $result = $this->usecase->__invoke($input);

            $response = new ResponseJsend($this->adapter->toArray($result));

            return response()
                ->json($response->toArray(), 201);
        } catch (CreateGenreException $e) {
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
