<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Usecase\CastMember;

use App\Core\Application\DTO\CastMember\CreateCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\CreateCastMemberOutputDTO;

interface CreateCastMemberUsecaseInterface
{
    public function __invoke(CreateCastMemberInputDTO $input): CreateCastMemberOutputDTO;
}
