<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Application\Usecase\CastMember;

use App\Core\Application\DTO\CastMember\DeleteCastMemberInputDTO;
use App\Core\Application\Interfaces\Usecase\CastMember\DeleteCastMemberUsecaseInterface;
use App\Core\Application\Usecase\CastMember\DeleteCastMemberUsecase;
use App\Core\Domain\Entity\CastMemberEntity;
use App\Core\Domain\Repository\CastMemberRepositoryInterface;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Enum\CastMemberTypeEnum;
use App\Core\Exception\CastMemberNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class DeleteCastMemberUsecaseUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_delete_cast_member(): void
    {
        $castMemberId = UuidResolver::random();
        $castMember = new CastMemberEntity(
            id: $castMemberId,
            name: 'Scarlett Johansson',
            type: CastMemberTypeEnum::ACTOR,
        );
        $input = new DeleteCastMemberInputDTO(id: (string) $castMemberId);

        $repository = Mockery::mock(CastMemberRepositoryInterface::class);
        $repository
            ->shouldReceive('findById')
            ->once()
            ->with((string) $castMemberId)
            ->andReturn($castMember);
        $repository
            ->shouldReceive('delete')
            ->once()
            ->with((string) $castMemberId);

        $usecase = new DeleteCastMemberUsecase($repository);

        $this->assertInstanceOf(DeleteCastMemberUsecaseInterface::class, $usecase);

        $usecase($input);
    }

    public function test_delete_cast_member_throws_exception_when_it_does_not_exist(): void
    {
        $castMemberId = (string) UuidResolver::random();
        $input = new DeleteCastMemberInputDTO(id: $castMemberId);

        $repository = Mockery::mock(CastMemberRepositoryInterface::class);
        $repository
            ->shouldReceive('findById')
            ->once()
            ->with($castMemberId)
            ->andReturnNull();
        $repository->shouldNotReceive('delete');

        $usecase = new DeleteCastMemberUsecase($repository);

        $this->expectException(CastMemberNotFoundException::class);
        $this->expectExceptionMessage('Membro do elenco não encontrado');

        $usecase($input);
    }
}
