<?php

declare(strict_types=1);

namespace App\Http\Controllers\Category;

use App\Core\Application\Interfaces\Adapter\Category\UpdateCategoryDataAdapterInterface;
use App\Core\Application\Interfaces\Usecase\Category\UpdateCategoryUsecaseInterface;
use App\Core\Exception\UpdateCategoryException;
use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseJsend;
use App\Http\Requests\Category\UpdateCategoryRequest;
use Illuminate\Http\JsonResponse;

class UpdateCategoryController extends Controller
{
    public function __construct(
        private readonly UpdateCategoryUsecaseInterface $usecase,
        private readonly UpdateCategoryDataAdapterInterface $adapter,
    ) {}

    public function __invoke(UpdateCategoryRequest $request): JsonResponse
    {
        try {
            $input = $this->adapter->fromArray($request->validated());

            $result = $this->usecase->__invoke($input);

            $response = new ResponseJsend($this->adapter->toArray($result));

            return response()
                ->json($response->toArray());
        } catch (UpdateCategoryException $e) {
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
