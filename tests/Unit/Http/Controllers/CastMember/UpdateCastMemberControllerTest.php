<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\CastMember;

use App\Core\Application\DTO\CastMember\UpdateCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\UpdateCastMemberOutputDTO;
use App\Core\Application\Interfaces\Adapter\CastMember\UpdateCastMemberDataAdapterInterface;
use App\Core\Application\Interfaces\Usecase\CastMember\UpdateCastMemberUsecaseInterface;
use App\Http\Controllers\CastMember\UpdateCastMemberController;
use App\Http\Requests\CastMember\UpdateCastMemberRequest;
use Mockery;
use Tests\TestCase;

class UpdateCastMemberControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_it_updates_cast_member_using_adapter_and_usecase(): void
    {
        $validated = [
            'id' => 'cast-member-id',
            'name' => 'Jordan Peele',
            'type' => 1,
        ];

        $input = new UpdateCastMemberInputDTO(
            id: 'cast-member-id',
            name: 'Jordan Peele',
            type: 1,
        );

        $output = new UpdateCastMemberOutputDTO(
            id: 'cast-member-id',
            name: 'Jordan Peele',
            type: 1,
            createdAt: '2026-08-28 10:00:00',
        );

        $responseData = [
            'id' => 'cast-member-id',
            'name' => 'Jordan Peele',
            'type' => 1,
            'created_at' => '2026-08-28 10:00:00',
        ];

        $request = Mockery::mock(UpdateCastMemberRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn($validated);

        $adapter = Mockery::mock(UpdateCastMemberDataAdapterInterface::class);
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

        $usecase = Mockery::mock(UpdateCastMemberUsecaseInterface::class);
        $usecase
            ->shouldReceive('__invoke')
            ->once()
            ->with($input)
            ->andReturn($output);

        $controller = new UpdateCastMemberController($usecase, $adapter);

        $response = $controller($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame([
            'status' => 'success',
            'data' => $responseData,
        ], $response->getData(true));
    }
}
