<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\CastMember;

use App\Core\Application\DTO\CastMember\CreateCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\CreateCastMemberOutputDTO;
use App\Core\Application\Interfaces\Adapter\CastMember\CreateCastMemberDataAdapterInterface;
use App\Core\Application\Interfaces\Usecase\CastMember\CreateCastMemberUsecaseInterface;
use App\Http\Controllers\CastMember\CreateCastMemberController;
use App\Http\Requests\CastMember\CreateCastMemberRequest;
use Mockery;
use Tests\TestCase;

class CreateCastMemberControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_it_creates_cast_member_using_adapter_and_usecase(): void
    {
        $validated = [
            'name' => 'Christopher Nolan',
            'type' => 1,
        ];

        $input = new CreateCastMemberInputDTO(
            name: 'Christopher Nolan',
            type: 1,
        );

        $output = new CreateCastMemberOutputDTO(
            id: 'cast-member-id',
            name: 'Christopher Nolan',
            type: 1,
            createdAt: '2026-08-28 10:00:00',
        );

        $responseData = [
            'id' => 'cast-member-id',
            'name' => 'Christopher Nolan',
            'type' => 1,
            'created_at' => '2026-08-28 10:00:00',
        ];

        $request = Mockery::mock(CreateCastMemberRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn($validated);

        $adapter = Mockery::mock(CreateCastMemberDataAdapterInterface::class);
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

        $usecase = Mockery::mock(CreateCastMemberUsecaseInterface::class);
        $usecase
            ->shouldReceive('__invoke')
            ->once()
            ->with($input)
            ->andReturn($output);

        $controller = new CreateCastMemberController($usecase, $adapter);

        $response = $controller($request);

        $this->assertSame(201, $response->getStatusCode());
        $this->assertSame([
            'status' => 'success',
            'data' => $responseData,
        ], $response->getData(true));
    }
}
