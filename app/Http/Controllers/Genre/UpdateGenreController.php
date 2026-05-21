<?php

declare(strict_types=1);

namespace App\Http\Controllers\Genre;

use App\Core\Application\Interfaces\Adapter\Genre\UpdateGenreDataAdapterInterface;
use App\Core\Application\Interfaces\Usecase\Genre\UpdateGenreUsecaseInterface;
use App\Core\Exception\UpdateGenreException;
use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseJsend;
use App\Http\Requests\Genre\UpdateGenreRequest;
use Illuminate\Http\JsonResponse;

class UpdateGenreController extends Controller
{
    public function __construct(
        private readonly UpdateGenreUsecaseInterface $usecase,
        private readonly UpdateGenreDataAdapterInterface $adapter,
    ) {}

    public function __invoke(UpdateGenreRequest $request): JsonResponse
    {
        try {
            $input = $this->adapter->fromArray($request->validated());

            $result = $this->usecase->__invoke($input);

            $response = new ResponseJsend($this->adapter->toArray($result));

            return response()
                ->json($response->toArray(), 200);
        } catch (UpdateGenreException $e) {
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
