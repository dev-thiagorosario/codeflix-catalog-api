<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\CastMember;

class UpdateCastMemberInputDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public int $type,
    ) {}
}
