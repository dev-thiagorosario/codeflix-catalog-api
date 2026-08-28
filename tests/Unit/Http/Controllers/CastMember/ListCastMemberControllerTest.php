<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\CastMember;

use App\Core\Application\DTO\CastMember\ListCastMembersInputDTO;
use App\Core\Application\DTO\CastMember\ListCastMembersOutputDTO;
use App\Core\Application\Interfaces\Adapter\CastMember\ListCastMembersDataAdapterInterface;
use App\Core\Application\Interfaces\Usecase\CastMember\ListCastMembersUsecaseInterface;
use App\Http\Controllers\CastMember\ListCastMemberController;
use App\Http\Requests\CastMember\ListCastMemberRequest;
use Mockery;
use Tests\TestCase;

class ListCastMemberControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_it_lists_cast_members_using_adapter_and_usecase(): void
    {
        $validated = [
            'name' => 'Christopher',
            'page' => 2,
            'per_page' => 10,
            'order' => 'ASC',
        ];

        $input = new ListCastMembersInputDTO(
            name: 'Christopher',
            page: 2,
            perPage: 10,
            order: 'ASC',
        );

        $output = new ListCastMembersOutputDTO(
            items: [[
                'id' => 'cast-member-id',
                'name' => 'Christopher Nolan',
                'type' => 1,
                'createdAt' => '2026-08-28 10:00:00',
            ]],
            total: 1,
            currentPage: 2,
            lastPage: 3,
            perPage: 10,
        );

        $responseData = [
            'items' => [[
                'id' => 'cast-member-id',
                'name' => 'Christopher Nolan',
                'type' => 1,
                'created_at' => '2026-08-28 10:00:00',
            ]],
            'meta' => [
                'total' => 1,
                'current_page' => 2,
                'last_page' => 3,
                'per_page' => 10,
            ],
        ];

        $request = Mockery::mock(ListCastMemberRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn($validated);

        $adapter = Mockery::mock(ListCastMembersDataAdapterInterface::class);
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

        $usecase = Mockery::mock(ListCastMembersUsecaseInterface::class);
        $usecase
            ->shouldReceive('__invoke')
            ->once()
            ->with($input)
            ->andReturn($output);

        $controller = new ListCastMemberController($usecase, $adapter);

        $response = $controller($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame([
            'status' => 'success',
            'data' => $responseData,
        ], $response->getData(true));
    }
}
