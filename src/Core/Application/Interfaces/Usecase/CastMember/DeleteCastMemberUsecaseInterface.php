<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Usecase\CastMember;

use App\Core\Application\DTO\CastMember\DeleteCastMemberInputDTO;

interface DeleteCastMemberUsecaseInterface
{
    public function __invoke(DeleteCastMemberInputDTO $input): void;
}
