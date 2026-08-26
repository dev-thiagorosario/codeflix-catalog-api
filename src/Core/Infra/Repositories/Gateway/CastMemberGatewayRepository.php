<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\Gateway;

use App\Core\Domain\Entity\CastMemberEntity;
use App\Core\Domain\Repository\CastMemberRepositoryInterface;
use App\Core\Domain\Repository\PaginationInterface;
use App\Core\Infra\Repositories\EloquentRepository\CastMember\CreateCastMemberEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\CastMember\DeleteCastMemberEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\CastMember\FindAllCastMembersEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\CastMember\FindCastMemberByIdEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\CastMember\UpdateCastMemberEloquentRepository;

final readonly class CastMemberGatewayRepository implements CastMemberRepositoryInterface
{
    public function __construct(
        private CreateCastMemberEloquentRepository $createCastMemberRepository,
        private FindCastMemberByIdEloquentRepository $findCastMemberByIdRepository,
        private FindAllCastMembersEloquentRepository $findAllCastMembersRepository,
        private UpdateCastMemberEloquentRepository $updateCastMemberRepository,
        private DeleteCastMemberEloquentRepository $deleteCastMemberRepository,
    ) {}

    public function insert(CastMemberEntity $castMember): CastMemberEntity
    {
        return $this->createCastMemberRepository->insert($castMember);
    }

    public function findById(string $id): ?CastMemberEntity
    {
        return $this->findCastMemberByIdRepository->findById($id);
    }

    /**
     * @return CastMemberEntity[]
     */
    public function findAll(string $filter = '', string $order = 'DESC'): array
    {
        return $this->findAllCastMembersRepository->findAll($filter, $order);
    }

    public function paginate(string $filter = '', string $order = 'DESC', int $page = 1, int $perPage = 10): PaginationInterface
    {
        return $this->findAllCastMembersRepository->paginate($filter, $order, $page, $perPage);
    }

    public function update(CastMemberEntity $castMember): CastMemberEntity
    {
        return $this->updateCastMemberRepository->update($castMember);
    }

    public function delete(string $id): void
    {
        $this->deleteCastMemberRepository->delete($id);
    }
}
