<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Application\Usecase\CastMember;

use App\Core\Application\DTO\CastMember\ListCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\ListCastMemberOutputDTO;
use App\Core\Application\DTO\CastMember\ListCastMembersInputDTO;
use App\Core\Application\DTO\CastMember\ListCastMembersOutputDTO;
use App\Core\Application\Interfaces\Usecase\CastMember\ListCastMembersUsecaseInterface;
use App\Core\Application\Interfaces\Usecase\CastMember\ListCastMemberUsecaseInterface;
use App\Core\Application\Usecase\CastMember\ListCastMembersUsecase;
use App\Core\Application\Usecase\CastMember\ListCastMemberUsecase;
use App\Core\Domain\Entity\CastMemberEntity;
use App\Core\Domain\Repository\CastMemberRepositoryInterface;
use App\Core\Domain\Repository\PaginationInterface;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Enum\CastMemberTypeEnum;
use App\Core\Exception\CastMemberNotFoundException;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;

class ListCastMemberUsecaseTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_list_cast_member_by_id(): void
    {
        $castMemberId = UuidResolver::random();
        $castMember = new CastMemberEntity(
            id: $castMemberId,
            name: 'Viola Davis',
            type: CastMemberTypeEnum::ACTOR,
            createdAt: new DateTime('2026-08-25 11:00:00'),
        );
        $input = new ListCastMemberInputDTO(id: (string) $castMemberId);

        $repository = Mockery::mock(CastMemberRepositoryInterface::class);
        $repository
            ->shouldReceive('findById')
            ->once()
            ->with((string) $castMemberId)
            ->andReturn($castMember);

        $usecase = new ListCastMemberUsecase($repository);
        $result = $usecase($input);

        $this->assertInstanceOf(ListCastMemberUsecaseInterface::class, $usecase);
        $this->assertInstanceOf(ListCastMemberOutputDTO::class, $result);
        $this->assertSame((string) $castMemberId, $result->id);
        $this->assertSame('Viola Davis', $result->name);
        $this->assertSame(CastMemberTypeEnum::ACTOR->value, $result->type);
        $this->assertSame('2026-08-25 11:00:00', $result->createdAt);
    }

    public function test_list_cast_member_by_id_throws_exception_when_it_does_not_exist(): void
    {
        $castMemberId = (string) UuidResolver::random();
        $input = new ListCastMemberInputDTO(id: $castMemberId);

        $repository = Mockery::mock(CastMemberRepositoryInterface::class);
        $repository
            ->shouldReceive('findById')
            ->once()
            ->with($castMemberId)
            ->andReturnNull();

        $usecase = new ListCastMemberUsecase($repository);

        $this->expectException(CastMemberNotFoundException::class);
        $this->expectExceptionMessage('Membro do elenco não encontrado');

        $usecase($input);
    }

    public function test_list_cast_members(): void
    {
        $castMemberId = UuidResolver::random();
        $castMember = new CastMemberEntity(
            id: $castMemberId,
            name: 'Greta Gerwig',
            type: CastMemberTypeEnum::DIRECTOR,
            createdAt: new DateTime('2026-08-25 12:00:00'),
        );
        $input = new ListCastMembersInputDTO(
            name: 'Greta',
            page: 2,
            perPage: 10,
            order: 'ASC',
        );

        $paginator = Mockery::mock(PaginationInterface::class);
        $paginator->shouldReceive('items')->once()->andReturn([$castMember]);
        $paginator->shouldReceive('total')->once()->andReturn(11);
        $paginator->shouldReceive('currentPage')->once()->andReturn(2);
        $paginator->shouldReceive('lastPage')->once()->andReturn(2);
        $paginator->shouldReceive('perPage')->once()->andReturn(10);

        $repository = Mockery::mock(CastMemberRepositoryInterface::class);
        $repository
            ->shouldReceive('paginate')
            ->once()
            ->with('Greta', 'ASC', 2, 10)
            ->andReturn($paginator);

        $usecase = new ListCastMembersUsecase($repository);
        $result = $usecase($input);

        $this->assertInstanceOf(ListCastMembersUsecaseInterface::class, $usecase);
        $this->assertInstanceOf(ListCastMembersOutputDTO::class, $result);
        $this->assertSame(11, $result->total);
        $this->assertSame(2, $result->currentPage);
        $this->assertSame(2, $result->lastPage);
        $this->assertSame(10, $result->perPage);
        $this->assertSame([
            [
                'id' => (string) $castMemberId,
                'name' => 'Greta Gerwig',
                'type' => CastMemberTypeEnum::DIRECTOR->value,
                'createdAt' => '2026-08-25 12:00:00',
            ],
        ], $result->items);
    }

    public function test_list_cast_members_uses_default_input_values(): void
    {
        $input = new ListCastMembersInputDTO;

        $paginator = Mockery::mock(PaginationInterface::class);
        $paginator->shouldReceive('items')->once()->andReturn([]);
        $paginator->shouldReceive('total')->once()->andReturn(0);
        $paginator->shouldReceive('currentPage')->once()->andReturn(1);
        $paginator->shouldReceive('lastPage')->once()->andReturn(1);
        $paginator->shouldReceive('perPage')->once()->andReturn(10);

        $repository = Mockery::mock(CastMemberRepositoryInterface::class);
        $repository
            ->shouldReceive('paginate')
            ->once()
            ->with('', 'DESC', 1, 10)
            ->andReturn($paginator);

        $result = (new ListCastMembersUsecase($repository))($input);

        $this->assertSame([], $result->items);
        $this->assertSame(0, $result->total);
        $this->assertSame(1, $result->currentPage);
        $this->assertSame(1, $result->lastPage);
        $this->assertSame(10, $result->perPage);
    }
}
