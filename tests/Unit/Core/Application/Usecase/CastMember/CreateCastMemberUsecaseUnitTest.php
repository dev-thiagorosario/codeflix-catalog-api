<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Application\Usecase\CastMember;

use App\Core\Application\DTO\CastMember\CreateCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\CreateCastMemberOutputDTO;
use App\Core\Application\Interfaces\Usecase\CastMember\CreateCastMemberUsecaseInterface;
use App\Core\Application\Usecase\CastMember\CreateCastMemberUsecase;
use App\Core\Domain\Entity\CastMemberEntity;
use App\Core\Domain\Repository\CastMemberRepositoryInterface;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Enum\CastMemberTypeEnum;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;
use ValueError;

class CreateCastMemberUsecaseUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_create_new_cast_member(): void
    {
        $castMemberId = UuidResolver::random();
        $input = new CreateCastMemberInputDTO(
            name: 'Christopher Nolan',
            type: CastMemberTypeEnum::DIRECTOR->value,
        );
        $savedCastMember = new CastMemberEntity(
            id: $castMemberId,
            name: 'Christopher Nolan',
            type: CastMemberTypeEnum::DIRECTOR,
            createdAt: new DateTime('2026-08-25 10:00:00'),
        );

        $repository = Mockery::mock(CastMemberRepositoryInterface::class);
        $repository
            ->shouldReceive('insert')
            ->once()
            ->with(Mockery::on(
                fn (CastMemberEntity $castMember): bool => $castMember->name === 'Christopher Nolan'
                    && $castMember->type === CastMemberTypeEnum::DIRECTOR
            ))
            ->andReturn($savedCastMember);

        $usecase = new CreateCastMemberUsecase($repository);
        $result = $usecase($input);

        $this->assertInstanceOf(CreateCastMemberUsecaseInterface::class, $usecase);
        $this->assertInstanceOf(CreateCastMemberOutputDTO::class, $result);
        $this->assertSame((string) $castMemberId, $result->id);
        $this->assertSame('Christopher Nolan', $result->name);
        $this->assertSame(CastMemberTypeEnum::DIRECTOR->value, $result->type);
        $this->assertSame('2026-08-25 10:00:00', $result->createdAt);
    }

    public function test_it_does_not_insert_cast_member_with_invalid_type(): void
    {
        $input = new CreateCastMemberInputDTO(
            name: 'Christopher Nolan',
            type: 999,
        );

        $repository = Mockery::mock(CastMemberRepositoryInterface::class);
        $repository->shouldNotReceive('insert');

        $usecase = new CreateCastMemberUsecase($repository);

        $this->expectException(ValueError::class);

        $usecase($input);
    }
}
