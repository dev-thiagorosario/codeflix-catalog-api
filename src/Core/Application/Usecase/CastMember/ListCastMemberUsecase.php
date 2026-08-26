<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\CastMember;

use App\Core\Application\DTO\CastMember\ListCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\ListCastMemberOutputDTO;
use App\Core\Application\Interfaces\Usecase\CastMember\ListCastMemberUsecaseInterface;
use App\Core\Domain\Repository\CastMemberRepositoryInterface;
use App\Core\Exception\CastMemberNotFoundException;

final class ListCastMemberUsecase implements ListCastMemberUsecaseInterface
{
    public function __construct(
        private readonly CastMemberRepositoryInterface $repository
    ) {}

    public function __invoke(ListCastMemberInputDTO $input): ListCastMemberOutputDTO
    {
        $castMember = $this->repository->findById($input->id);

        if ($castMember === null) {
            throw new CastMemberNotFoundException;
        }

        return new ListCastMemberOutputDTO(
            id: $castMember->id(),
            name: $castMember->name,
            type: $castMember->type->value,
            createdAt: $castMember->createdAt(),
        );
    }
}
