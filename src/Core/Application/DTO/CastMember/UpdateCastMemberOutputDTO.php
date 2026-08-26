<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\CastMember;

class UpdateCastMemberOutputDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public int $type,
        public string $createdAt,
    ) {}
}
