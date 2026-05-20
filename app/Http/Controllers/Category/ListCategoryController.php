<?php

declare(strict_types=1);

namespace App\Http\Controllers\Category;

use App\Core\Application\Interfaces\Category\ListCategoryDataAdapterInterface;
use App\Core\Application\Interfaces\Category\ListCategoryUsecaseInterface;
use App\Core\Exception\ListCategoryException;
use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseJsend;
use App\Http\Requests\Category\ListCategoryRequest;
use Illuminate\Http\JsonResponse;

class ListCategoryController extends Controller
{
    public function __construct(
        private readonly ListCategoryUsecaseInterface $usecase,
        private readonly ListCategoryDataAdapterInterface $adapter,
    ) {}

    public function __invoke(ListCategoryRequest $request): JsonResponse
    {
        try {
            $input = $this->adapter->fromArray($request->validated());

            $result = $this->usecase->__invoke($input);

            $response = new ResponseJsend($this->adapter->toArray($result));

            return response()
                ->json($response->toArray());
        } catch (ListCategoryException $e) {
            $response = new ResponseJsend(
                status: 'error',
                message: $e->getMessage(),
                code: $e->getCode(),
            );

            return response()
                ->json($response->toArray(), 500);
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
