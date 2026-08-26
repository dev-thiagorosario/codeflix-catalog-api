<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\EloquentRepository\CastMember;

use App\Core\Domain\Entity\CastMemberEntity;
use App\Models\CastMember;

class FindCastMemberByIdEloquentRepository
{
    public function findById(string $id): ?CastMemberEntity
    {
        $model = CastMember::query()->find($id);

        if ($model === null) {
            return null;
        }

        return CastMemberEntity::fromModel($model);
    }
}
