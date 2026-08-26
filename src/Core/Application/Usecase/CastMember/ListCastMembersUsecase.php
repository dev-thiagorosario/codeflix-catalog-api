<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\CastMember;

use App\Core\Application\DTO\CastMember\ListCastMembersInputDTO;
use App\Core\Application\DTO\CastMember\ListCastMembersOutputDTO;
use App\Core\Application\Interfaces\Usecase\CastMember\ListCastMembersUsecaseInterface;
use App\Core\Domain\Entity\CastMemberEntity;
use App\Core\Domain\Repository\CastMemberRepositoryInterface;

final class ListCastMembersUsecase implements ListCastMembersUsecaseInterface
{
    public function __construct(
        private readonly CastMemberRepositoryInterface $repository
    ) {}

    public function __invoke(ListCastMembersInputDTO $input): ListCastMembersOutputDTO
    {
        $castMembers = $this->repository->paginate(
            filter: $input->name ?? '',
            order: $input->order,
            page: $input->page ?? 1,
            perPage: $input->perPage ?? 10,
        );

        return new ListCastMembersOutputDTO(
            items: array_map(
                fn (CastMemberEntity $castMember): array => [
                    'id' => $castMember->id(),
                    'name' => $castMember->name,
                    'type' => $castMember->type->value,
                    'createdAt' => $castMember->createdAt(),
                ],
                $castMembers->items()
            ),
            total: $castMembers->total(),
            currentPage: $castMembers->currentPage(),
            lastPage: $castMembers->lastPage(),
            perPage: $castMembers->perPage(),
        );
    }
}
