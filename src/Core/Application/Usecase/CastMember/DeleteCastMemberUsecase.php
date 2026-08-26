<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\CastMember;

use App\Core\Application\DTO\CastMember\DeleteCastMemberInputDTO;
use App\Core\Application\Interfaces\Usecase\CastMember\DeleteCastMemberUsecaseInterface;
use App\Core\Domain\Repository\CastMemberRepositoryInterface;
use App\Core\Exception\CastMemberNotFoundException;

final class DeleteCastMemberUsecase implements DeleteCastMemberUsecaseInterface
{
    public function __construct(
        private readonly CastMemberRepositoryInterface $repository
    ) {}

    public function __invoke(DeleteCastMemberInputDTO $input): void
    {
        $castMember = $this->repository->findById($input->id);

        if ($castMember === null) {
            throw new CastMemberNotFoundException;
        }

        $this->repository->delete($input->id);
    }
}
