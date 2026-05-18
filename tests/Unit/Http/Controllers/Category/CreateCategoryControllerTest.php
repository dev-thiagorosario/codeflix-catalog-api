<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Category;

use App\Core\Application\DTO\Category\CreateCategoryInputDTO;
use App\Core\Application\DTO\Category\CreateCategoryOutputDTO;
use App\Core\Application\Usecase\Category\CreateCategoryUsecaseInterface;
use App\Core\Infra\Adapter\Category\CreateCategoryAdapterInterface;
use App\Http\Controllers\Category\CreateCategoryController;
use App\Http\Requests\Category\CreateCategoryRequest;
use Mockery;
use Tests\TestCase;

class CreateCategoryControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_it_creates_category_using_adapter_and_usecase(): void
    {
        $validated = [
            'name' => 'Movies',
            'description' => 'Movie category',
            'is_active' => true,
        ];

        $input = new CreateCategoryInputDTO(
            name: 'Movies',
            description: 'Movie category',
            isActive: true,
        );

        $output = new CreateCategoryOutputDTO(
            id: 'category-id',
            name: 'Movies',
            description: 'Movie category',
            isActive: true,
            createdAt: '2026-05-18 10:00:00',
        );

        $responseData = [
            'id' => 'category-id',
            'name' => 'Movies',
            'description' => 'Movie category',
            'is_active' => true,
            'created_at' => '2026-05-18 10:00:00',
        ];

        $request = Mockery::mock(CreateCategoryRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn($validated);

        $adapter = Mockery::mock(CreateCategoryAdapterInterface::class);
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

        $usecase = Mockery::mock(CreateCategoryUsecaseInterface::class);
        $usecase
            ->shouldReceive('__invoke')
            ->once()
            ->with($input)
            ->andReturn($output);

        $controller = new CreateCategoryController($usecase, $adapter);

        $response = $controller($request);

        $this->assertSame(201, $response->getStatusCode());
        $this->assertSame([
            'status' => 'success',
            'data' => $responseData,
        ], $response->getData(true));
    }
}
