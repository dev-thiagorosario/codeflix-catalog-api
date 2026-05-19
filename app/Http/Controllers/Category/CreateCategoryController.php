<?php

declare(strict_types=1);

namespace App\Http\Controllers\Category;

use App\Core\Application\Usecase\Category\CreateCategoryUsecaseInterface;
use App\Core\Exception\CreateCategoryException;
use App\Core\Infra\Adapter\Category\CreateCategoryDataAdapterInterface;
use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseJsend;
use App\Http\Requests\Category\CreateCategoryRequest;
use Illuminate\Http\JsonResponse;

class CreateCategoryController extends Controller
{
    public function __construct(
        private readonly CreateCategoryUsecaseInterface $usecase,
        private readonly CreateCategoryDataAdapterInterface $adapter,
    ) {}

    public function __invoke(CreateCategoryRequest $request): JsonResponse
    {
        try {
            $input = $this->adapter->fromArray($request->validated());

            $result = $this->usecase->__invoke($input);

            $response = new ResponseJsend($this->adapter->toArray($result));

            return response()
                ->json($response->toArray(), 201);
        } catch (CreateCategoryException $e) {
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
