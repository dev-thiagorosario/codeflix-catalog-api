<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Category;

use App\Core\Application\DTO\Category\UpdateCategoryInputDTO;
use App\Core\Application\DTO\Category\UpdateCategoryOutputDTO;
use App\Core\Application\Interfaces\Adapter\Category\UpdateCategoryDataAdapterInterface;
use App\Core\Application\Interfaces\Usecase\Category\UpdateCategoryUsecaseInterface;
use App\Http\Controllers\Category\UpdateCategoryController;
use App\Http\Requests\Category\UpdateCategoryRequest;
use Mockery;
use Tests\TestCase;

class UpdateCategoryControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_it_updates_category_using_adapter_and_usecase(): void
    {
        $validated = [
            'id' => 'category-id',
            'name' => 'Movies',
            'description' => 'Movie category',
            'is_active' => true,
        ];

        $input = new UpdateCategoryInputDTO(
            id: 'category-id',
            name: 'Movies',
            description: 'Movie category',
            isActive: true,
        );

        $output = new UpdateCategoryOutputDTO(
            id: 'category-id',
            name: 'Movies',
            description: 'Movie category',
            isActive: true,
            updatedAt: '2026-05-18 10:00:00',
        );

        $responseData = [
            'id' => 'category-id',
            'name' => 'Movies',
            'description' => 'Movie category',
            'is_active' => true,
            'updated_at' => '2026-05-18 10:00:00',
        ];

        $request = Mockery::mock(UpdateCategoryRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn($validated);

        $adapter = Mockery::mock(UpdateCategoryDataAdapterInterface::class);
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

        $usecase = Mockery::mock(UpdateCategoryUsecaseInterface::class);
        $usecase
            ->shouldReceive('__invoke')
            ->once()
            ->with($input)
            ->andReturn($output);

        $controller = new UpdateCategoryController($usecase, $adapter);

        $response = $controller($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame([
            'status' => 'success',
            'data' => $responseData,
        ], $response->getData(true));
    }
}
