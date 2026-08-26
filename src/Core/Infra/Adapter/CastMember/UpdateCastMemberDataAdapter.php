<?php

declare(strict_types=1);

namespace App\Core\Infra\Adapter\CastMember;

use App\Core\Application\DTO\CastMember\UpdateCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\UpdateCastMemberOutputDTO;
use App\Core\Application\Interfaces\Adapter\CastMember\UpdateCastMemberDataAdapterInterface;

class UpdateCastMemberDataAdapter implements UpdateCastMemberDataAdapterInterface
{
    /**
     * @param  array{id: string, name: string, type: int|string}  $data
     */
    public function fromArray(array $data): UpdateCastMemberInputDTO
    {
        return new UpdateCastMemberInputDTO(
            id: $data['id'],
            name: $data['name'],
            type: (int) $data['type'],
        );
    }

    /**
     * @return array{id: string, name: string, type: int, created_at: string}
     */
    public function toArray(UpdateCastMemberOutputDTO $castMember): array
    {
        return [
            'id' => $castMember->id,
            'name' => $castMember->name,
            'type' => $castMember->type,
            'created_at' => $castMember->createdAt,
        ];
    }
}
