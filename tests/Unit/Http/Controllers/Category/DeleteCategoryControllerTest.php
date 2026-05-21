<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Category;

use App\Core\Application\DTO\Category\DeleteCategoryInputDTO;
use App\Core\Application\Interfaces\Usecase\Category\DeleteCategoryUsecaseInterface;
use App\Core\Exception\CategoryNotFoundException;
use App\Http\Controllers\Category\DeleteCategoryController;
use App\Http\Requests\Category\DeleteCategoryRequest;
use Mockery;
use Tests\TestCase;

class DeleteCategoryControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_it_deletes_category_using_usecase(): void
    {
        $validated = [
            'id' => 'category-id',
        ];

        $request = Mockery::mock(DeleteCategoryRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn($validated);

        $usecase = Mockery::mock(DeleteCategoryUsecaseInterface::class);
        $usecase
            ->shouldReceive('__invoke')
            ->once()
            ->with(Mockery::on(fn (DeleteCategoryInputDTO $input): bool => $input->id === 'category-id'))
            ->andReturnNull();

        $controller = new DeleteCategoryController($usecase);

        $response = $controller($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame([
            'status' => 'success',
            'data' => [],
        ], $response->getData(true));
    }

    public function test_it_returns_not_found_when_category_does_not_exist(): void
    {
        $validated = [
            'id' => 'category-id',
        ];

        $exception = new CategoryNotFoundException;

        $request = Mockery::mock(DeleteCategoryRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn($validated);

        $usecase = Mockery::mock(DeleteCategoryUsecaseInterface::class);
        $usecase
            ->shouldReceive('__invoke')
            ->once()
            ->with(Mockery::on(fn (DeleteCategoryInputDTO $input): bool => $input->id === 'category-id'))
            ->andThrow($exception);

        $controller = new DeleteCategoryController($usecase);

        $response = $controller($request);

        $this->assertSame(404, $response->getStatusCode());
        $this->assertSame([
            'status' => 'error',
            'data' => [],
            'message' => 'Categoria Não Encontrada',
            'code' => 1004,
        ], $response->getData(true));
    }
}
