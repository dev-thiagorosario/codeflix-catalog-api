<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\CastMember;

class ListCastMemberInputDTO
{
    public function __construct(
        public string $id,
    ) {}
}
