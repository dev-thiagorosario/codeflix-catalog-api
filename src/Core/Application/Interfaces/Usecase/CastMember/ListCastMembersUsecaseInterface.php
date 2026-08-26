<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Usecase\CastMember;

use App\Core\Application\DTO\CastMember\ListCastMembersInputDTO;
use App\Core\Application\DTO\CastMember\ListCastMembersOutputDTO;

interface ListCastMembersUsecaseInterface
{
    public function __invoke(ListCastMembersInputDTO $input): ListCastMembersOutputDTO;
}
