<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\CastMember;

use App\Core\Application\DTO\CastMember\CreateCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\CreateCastMemberOutputDTO;
use App\Core\Application\Interfaces\Usecase\CastMember\CreateCastMemberUsecaseInterface;
use App\Core\Domain\Entity\CastMemberEntity;
use App\Core\Domain\Repository\CastMemberRepositoryInterface;
use App\Core\Enum\CastMemberTypeEnum;

final class CreateCastMemberUsecase implements CreateCastMemberUsecaseInterface
{
    public function __construct(
        private readonly CastMemberRepositoryInterface $repository
    ) {}

    public function __invoke(CreateCastMemberInputDTO $input): CreateCastMemberOutputDTO
    {
        $castMember = new CastMemberEntity(
            name: $input->name,
            type: CastMemberTypeEnum::from($input->type),
        );

        $castMemberCreated = $this->repository->insert($castMember);

        return new CreateCastMemberOutputDTO(
            id: $castMemberCreated->id(),
            name: $castMemberCreated->name,
            type: $castMemberCreated->type->value,
            createdAt: $castMemberCreated->createdAt(),
        );
    }
}
