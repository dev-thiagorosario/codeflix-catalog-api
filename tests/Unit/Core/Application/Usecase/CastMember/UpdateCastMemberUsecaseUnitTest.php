<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Application\Usecase\CastMember;

use App\Core\Application\DTO\CastMember\UpdateCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\UpdateCastMemberOutputDTO;
use App\Core\Application\Interfaces\Usecase\CastMember\UpdateCastMemberUsecaseInterface;
use App\Core\Application\Usecase\CastMember\UpdateCastMemberUsecase;
use App\Core\Domain\Entity\CastMemberEntity;
use App\Core\Domain\Repository\CastMemberRepositoryInterface;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Enum\CastMemberTypeEnum;
use App\Core\Exception\CastMemberNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;
use ValueError;

class UpdateCastMemberUsecaseUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_update_cast_member(): void
    {
        $castMemberId = UuidResolver::random();
        $castMember = new CastMemberEntity(
            id: $castMemberId,
            name: 'Jordan Peele',
            type: CastMemberTypeEnum::ACTOR,
            createdAt: '2026-08-25 13:00:00',
        );
        $input = new UpdateCastMemberInputDTO(
            id: (string) $castMemberId,
            name: 'Jordan Peele Updated',
            type: CastMemberTypeEnum::DIRECTOR->value,
        );

        $repository = Mockery::mock(CastMemberRepositoryInterface::class);
        $repository
            ->shouldReceive('findById')
            ->once()
            ->with((string) $castMemberId)
            ->andReturn($castMember);
        $repository
            ->shouldReceive('update')
            ->once()
            ->with(Mockery::on(
                fn (CastMemberEntity $castMember): bool => $castMember->name === 'Jordan Peele Updated'
                    && $castMember->type === CastMemberTypeEnum::DIRECTOR
            ))
            ->andReturnUsing(fn (CastMemberEntity $castMember): CastMemberEntity => $castMember);

        $usecase = new UpdateCastMemberUsecase($repository);
        $result = $usecase($input);

        $this->assertInstanceOf(UpdateCastMemberUsecaseInterface::class, $usecase);
        $this->assertInstanceOf(UpdateCastMemberOutputDTO::class, $result);
        $this->assertSame((string) $castMemberId, $result->id);
        $this->assertSame('Jordan Peele Updated', $result->name);
        $this->assertSame(CastMemberTypeEnum::DIRECTOR->value, $result->type);
        $this->assertSame('2026-08-25 13:00:00', $result->createdAt);
    }

    public function test_update_cast_member_throws_exception_when_it_does_not_exist(): void
    {
        $castMemberId = (string) UuidResolver::random();
        $input = new UpdateCastMemberInputDTO(
            id: $castMemberId,
            name: 'Jordan Peele Updated',
            type: CastMemberTypeEnum::DIRECTOR->value,
        );

        $repository = Mockery::mock(CastMemberRepositoryInterface::class);
        $repository
            ->shouldReceive('findById')
            ->once()
            ->with($castMemberId)
            ->andReturnNull();
        $repository->shouldNotReceive('update');

        $usecase = new UpdateCastMemberUsecase($repository);

        $this->expectException(CastMemberNotFoundException::class);
        $this->expectExceptionMessage('Membro do elenco não encontrado');

        $usecase($input);
    }

    public function test_it_does_not_update_cast_member_with_invalid_type(): void
    {
        $castMemberId = UuidResolver::random();
        $castMember = new CastMemberEntity(
            id: $castMemberId,
            name: 'Jordan Peele',
            type: CastMemberTypeEnum::DIRECTOR,
        );
        $input = new UpdateCastMemberInputDTO(
            id: (string) $castMemberId,
            name: 'Jordan Peele Updated',
            type: 999,
        );

        $repository = Mockery::mock(CastMemberRepositoryInterface::class);
        $repository
            ->shouldReceive('findById')
            ->once()
            ->with((string) $castMemberId)
            ->andReturn($castMember);
        $repository->shouldNotReceive('update');

        $usecase = new UpdateCastMemberUsecase($repository);

        try {
            $usecase($input);

            $this->fail('An invalid cast member type should throw an exception.');
        } catch (ValueError) {
            $this->assertSame('Jordan Peele', $castMember->name);
            $this->assertSame(CastMemberTypeEnum::DIRECTOR, $castMember->type);
        }
    }
}
