<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\CastMember;

class DeleteCastMemberInputDTO
{
    public function __construct(
        public string $id,
    ) {}
}
