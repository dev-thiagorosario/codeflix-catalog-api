<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Usecase\CastMember;

use App\Core\Application\DTO\CastMember\UpdateCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\UpdateCastMemberOutputDTO;

interface UpdateCastMemberUsecaseInterface
{
    public function __invoke(UpdateCastMemberInputDTO $input): UpdateCastMemberOutputDTO;
}
