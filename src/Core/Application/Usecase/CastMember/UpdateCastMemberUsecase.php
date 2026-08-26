<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\CastMember;

use App\Core\Application\DTO\CastMember\UpdateCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\UpdateCastMemberOutputDTO;
use App\Core\Application\Interfaces\Usecase\CastMember\UpdateCastMemberUsecaseInterface;
use App\Core\Domain\Repository\CastMemberRepositoryInterface;
use App\Core\Enum\CastMemberTypeEnum;
use App\Core\Exception\CastMemberNotFoundException;

final class UpdateCastMemberUsecase implements UpdateCastMemberUsecaseInterface
{
    public function __construct(
        private readonly CastMemberRepositoryInterface $repository
    ) {}

    public function __invoke(UpdateCastMemberInputDTO $input): UpdateCastMemberOutputDTO
    {
        $castMember = $this->repository->findById($input->id);

        if ($castMember === null) {
            throw new CastMemberNotFoundException;
        }

        $castMember->update(
            name: $input->name,
            type: CastMemberTypeEnum::from($input->type),
        );

        $castMemberUpdated = $this->repository->update($castMember);

        return new UpdateCastMemberOutputDTO(
            id: $castMemberUpdated->id(),
            name: $castMemberUpdated->name,
            type: $castMemberUpdated->type->value,
            createdAt: $castMemberUpdated->createdAt(),
        );
    }
}
