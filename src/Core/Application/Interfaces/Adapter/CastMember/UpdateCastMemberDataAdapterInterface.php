<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Adapter\CastMember;

use App\Core\Application\DTO\CastMember\UpdateCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\UpdateCastMemberOutputDTO;

interface UpdateCastMemberDataAdapterInterface
{
    /**
     * @param  array{id: string, name: string, type: int|string}  $data
     */
    public function fromArray(array $data): UpdateCastMemberInputDTO;

    /**
     * @return array{id: string, name: string, type: int, created_at: string}
     */
    public function toArray(UpdateCastMemberOutputDTO $castMember): array;
}
