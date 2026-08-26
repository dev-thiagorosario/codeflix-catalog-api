<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Adapter\CastMember;

use App\Core\Application\DTO\CastMember\CreateCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\CreateCastMemberOutputDTO;

interface CreateCastMemberDataAdapterInterface
{
    /**
     * @param  array{name: string, type: int|string}  $data
     */
    public function fromArray(array $data): CreateCastMemberInputDTO;

    /**
     * @return array{id: string, name: string, type: int, created_at: string}
     */
    public function toArray(CreateCastMemberOutputDTO $castMember): array;
}
