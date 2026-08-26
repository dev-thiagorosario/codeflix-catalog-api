<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\EloquentRepository\CastMember;

use App\Models\CastMember;

class DeleteCastMemberEloquentRepository
{
    public function delete(string $id): void
    {
        CastMember::query()->findOrFail($id)->delete();
    }
}
