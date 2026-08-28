<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\CastMember;

use App\Core\Application\DTO\CastMember\DeleteCastMemberInputDTO;
use App\Core\Application\Interfaces\Usecase\CastMember\DeleteCastMemberUsecaseInterface;
use App\Core\Exception\CastMemberNotFoundException;
use App\Http\Controllers\CastMember\DeleteCastMemberController;
use App\Http\Requests\CastMember\DeleteCastMemberRequest;
use Mockery;
use Tests\TestCase;

class DeleteCastMemberControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_it_deletes_cast_member_using_usecase(): void
    {
        $validated = [
            'id' => 'cast-member-id',
        ];

        $request = Mockery::mock(DeleteCastMemberRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn($validated);

        $usecase = Mockery::mock(DeleteCastMemberUsecaseInterface::class);
        $usecase
            ->shouldReceive('__invoke')
            ->once()
            ->with(Mockery::on(fn (DeleteCastMemberInputDTO $input): bool => $input->id === 'cast-member-id'))
            ->andReturnNull();

        $controller = new DeleteCastMemberController($usecase);

        $response = $controller($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame([
            'status' => 'success',
            'data' => [],
        ], $response->getData(true));
    }

    public function test_it_returns_not_found_when_cast_member_does_not_exist(): void
    {
        $validated = [
            'id' => 'cast-member-id',
        ];

        $request = Mockery::mock(DeleteCastMemberRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn($validated);

        $usecase = Mockery::mock(DeleteCastMemberUsecaseInterface::class);
        $usecase
            ->shouldReceive('__invoke')
            ->once()
            ->andThrow(new CastMemberNotFoundException);

        $controller = new DeleteCastMemberController($usecase);

        $response = $controller($request);

        $this->assertSame(404, $response->getStatusCode());
        $this->assertSame([
            'status' => 'error',
            'data' => [],
            'message' => 'Membro do elenco não encontrado',
            'code' => 1015,
        ], $response->getData(true));
    }
}
