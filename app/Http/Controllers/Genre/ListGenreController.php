<?php

declare(strict_types=1);

namespace App\Http\Controllers\Genre;

use App\Core\Application\Interfaces\Adapter\Genre\ListGenresDataAdapterInterface;
use App\Core\Application\Interfaces\Usecase\Genre\ListGenresUsecaseInterface;
use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseJsend;
use App\Core\Exception\ListGenreException;
use App\Http\Requests\Genre\ListGenreRequest;
use Illuminate\Http\JsonResponse;

class ListGenreController extends Controller
{
    public function __construct(
        private readonly ListGenresUsecaseInterface $usecase,
        private readonly ListGenresDataAdapterInterface $adapter,
    ) {}

    public function __invoke(ListGenreRequest $request): JsonResponse
    {
        try {
            $input = $this->adapter->fromArray($request->validated());

            $result = $this->usecase->__invoke($input);

            $response = new ResponseJsend($this->adapter->toArray($result));

            return response()
                ->json($response->toArray(), 200);
        }catch (ListGenreException $e){
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
