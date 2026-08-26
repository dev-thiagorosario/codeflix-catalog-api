<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\CastMember;

use App\Core\Domain\Entity\CastMemberEntity;
use App\Core\Domain\Repository\PaginationInterface;
use App\Core\Enum\CastMemberTypeEnum;
use App\Core\Infra\Repositories\EloquentRepository\CastMember\CreateCastMemberEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\CastMember\DeleteCastMemberEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\CastMember\FindAllCastMembersEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\CastMember\FindCastMemberByIdEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\CastMember\UpdateCastMemberEloquentRepository;
use App\Core\Infra\Repositories\Gateway\CastMemberGatewayRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class CastMemberGatewayRepositoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_it_delegates_operations_to_eloquent_repositories(): void
    {
        $castMember = new CastMemberEntity(
            name: 'Viola Davis',
            type: CastMemberTypeEnum::ACTOR,
        );
        $updatedCastMember = new CastMemberEntity(
            id: $castMember->id(),
            name: 'Viola Davis Updated',
            type: CastMemberTypeEnum::DIRECTOR,
        );
        $pagination = Mockery::mock(PaginationInterface::class);

        $createRepository = Mockery::mock(CreateCastMemberEloquentRepository::class);
        $findByIdRepository = Mockery::mock(FindCastMemberByIdEloquentRepository::class);
        $findAllRepository = Mockery::mock(FindAllCastMembersEloquentRepository::class);
        $updateRepository = Mockery::mock(UpdateCastMemberEloquentRepository::class);
        $deleteRepository = Mockery::mock(DeleteCastMemberEloquentRepository::class);

        $createRepository
            ->shouldReceive('insert')
            ->once()
            ->with($castMember)
            ->andReturn($castMember);

        $findByIdRepository
            ->shouldReceive('findById')
            ->once()
            ->with($castMember->id())
            ->andReturn($castMember);

        $findAllRepository
            ->shouldReceive('findAll')
            ->once()
            ->with('viola', 'ASC')
            ->andReturn([$castMember]);

        $findAllRepository
            ->shouldReceive('paginate')
            ->once()
            ->with('viola', 'DESC', 2, 15)
            ->andReturn($pagination);

        $updateRepository
            ->shouldReceive('update')
            ->once()
            ->with($updatedCastMember)
            ->andReturn($updatedCastMember);

        $deleteRepository
            ->shouldReceive('delete')
            ->once()
            ->with($castMember->id());

        $repository = new CastMemberGatewayRepository(
            $createRepository,
            $findByIdRepository,
            $findAllRepository,
            $updateRepository,
            $deleteRepository,
        );

        $this->assertSame($castMember, $repository->insert($castMember));
        $this->assertSame($castMember, $repository->findById($castMember->id()));
        $this->assertSame([$castMember], $repository->findAll('viola', 'ASC'));
        $this->assertSame($pagination, $repository->paginate('viola', 'DESC', 2, 15));
        $this->assertSame($updatedCastMember, $repository->update($updatedCastMember));

        $repository->delete($castMember->id());
    }
}
