<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Usecase\CastMember;

use App\Core\Application\DTO\CastMember\ListCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\ListCastMemberOutputDTO;

interface ListCastMemberUsecaseInterface
{
    public function __invoke(ListCastMemberInputDTO $input): ListCastMemberOutputDTO;
}
