<?php

declare(strict_types=1);

namespace App\Http\Controllers\Category;

use App\Core\Application\DTO\Category\DeleteCategoryInputDTO;
use App\Core\Application\Usecase\Category\DeleteCategoryUsecaseInterface;
use App\Core\Exception\CategoryNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseJsend;
use App\Http\Requests\Category\DeleteCategoryRequest;
use Illuminate\Http\JsonResponse;

class DeleteCategoryController extends Controller
{
    public function __construct(
        private readonly DeleteCategoryUsecaseInterface $usecase,
    ) {}

    public function __invoke(DeleteCategoryRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $input = new DeleteCategoryInputDTO(
                id: $validated['id'],
            );

            $this->usecase->__invoke($input);

            $response = new ResponseJsend;

            return response()
                ->json($response->toArray());
        } catch (CategoryNotFoundException $e) {
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
