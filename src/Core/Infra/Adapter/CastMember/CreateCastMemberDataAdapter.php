<?php

declare(strict_types=1);

namespace App\Core\Infra\Adapter\CastMember;

use App\Core\Application\DTO\CastMember\CreateCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\CreateCastMemberOutputDTO;
use App\Core\Application\Interfaces\Adapter\CastMember\CreateCastMemberDataAdapterInterface;

class CreateCastMemberDataAdapter implements CreateCastMemberDataAdapterInterface
{
    /**
     * @param  array{name: string, type: int|string}  $data
     */
    public function fromArray(array $data): CreateCastMemberInputDTO
    {
        return new CreateCastMemberInputDTO(
            name: $data['name'],
            type: (int) $data['type'],
        );
    }

    /**
     * @return array{id: string, name: string, type: int, created_at: string}
     */
    public function toArray(CreateCastMemberOutputDTO $castMember): array
    {
        return [
            'id' => $castMember->id,
            'name' => $castMember->name,
            'type' => $castMember->type,
            'created_at' => $castMember->createdAt,
        ];
    }
}
