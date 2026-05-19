<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Category;

use App\Core\Application\DTO\Category\ListCategoryInputDTO;
use App\Core\Application\DTO\Category\ListCategoryOutputDTO;
use App\Core\Application\Usecase\Category\ListCategoryUsecaseInterface;
use App\Core\Infra\Adapter\Category\ListCategoryDataAdapterInterface;
use App\Http\Controllers\Category\ListCategoryController;
use App\Http\Requests\Category\ListCategoryRequest;
use Mockery;
use Tests\TestCase;

class ListCategoryControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_it_lists_categories_using_adapter_and_usecase(): void
    {
        $validated = [
            'name' => 'Movies',
            'page' => 2,
            'per_page' => 10,
            'order' => 'ASC',
        ];

        $input = new ListCategoryInputDTO(
            name: 'Movies',
            page: 2,
            perPage: 10,
            order: 'ASC',
        );

        $output = new ListCategoryOutputDTO(
            items: [
                [
                    'id' => 'category-id',
                    'name' => 'Movies',
                    'description' => 'Movie category',
                    'isActive' => true,
                    'createdAt' => '2026-05-18 10:00:00',
                ],
            ],
            total: 1,
            currentPage: 2,
            lastPage: 3,
            perPage: 10,
        );

        $responseData = [
            'items' => [
                [
                    'id' => 'category-id',
                    'name' => 'Movies',
                    'description' => 'Movie category',
                    'is_active' => true,
                    'created_at' => '2026-05-18 10:00:00',
                ],
            ],
            'meta' => [
                'total' => 1,
                'current_page' => 2,
                'last_page' => 3,
                'per_page' => 10,
            ],
        ];

        $request = Mockery::mock(ListCategoryRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn($validated);

        $adapter = Mockery::mock(ListCategoryDataAdapterInterface::class);
        $adapter
            ->shouldReceive('fromArray')
            ->once()
            ->with($validated)
            ->andReturn($input);
        $adapter
            ->shouldReceive('toArray')
            ->once()
            ->with($output)
            ->andReturn($responseData);

        $usecase = Mockery::mock(ListCategoryUsecaseInterface::class);
        $usecase
            ->shouldReceive('__invoke')
            ->once()
            ->with($input)
            ->andReturn($output);

        $controller = new ListCategoryController($usecase, $adapter);

        $response = $controller($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame([
            'status' => 'success',
            'data' => $responseData,
        ], $response->getData(true));
    }
}
