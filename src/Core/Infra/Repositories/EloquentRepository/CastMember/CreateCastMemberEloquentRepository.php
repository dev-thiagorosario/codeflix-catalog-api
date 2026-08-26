<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\EloquentRepository\CastMember;

use App\Core\Domain\Entity\CastMemberEntity;
use App\Models\CastMember;

class CreateCastMemberEloquentRepository
{
    public function insert(CastMemberEntity $castMember): CastMemberEntity
    {
        $model = CastMember::query()->create([
            'id' => $castMember->id(),
            'name' => $castMember->name,
            'type' => $castMember->type->value,
        ]);

        return CastMemberEntity::fromModel($model);
    }
}
