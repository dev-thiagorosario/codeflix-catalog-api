<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\EloquentRepository\CastMember;

use App\Core\Domain\Entity\CastMemberEntity;
use App\Models\CastMember;

class UpdateCastMemberEloquentRepository
{
    public function update(CastMemberEntity $castMember): CastMemberEntity
    {
        $model = CastMember::query()->findOrFail($castMember->id());

        $model->update([
            'name' => $castMember->name,
            'type' => $castMember->type->value,
        ]);

        return CastMemberEntity::fromModel($model->refresh());
    }
}
