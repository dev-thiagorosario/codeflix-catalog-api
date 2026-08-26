<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\EloquentRepository\CastMember;

use App\Core\Domain\Entity\CastMemberEntity;
use App\Core\Domain\Repository\PaginationInterface;
use App\Core\Infra\Presenter\PaginationPresenter;
use App\Models\CastMember;

class FindAllCastMembersEloquentRepository
{
    /**
     * @return CastMemberEntity[]
     */
    public function findAll(string $filter = '', string $order = 'DESC'): array
    {
        $castMembers = CastMember::query()
            ->when($filter, function ($query, string $filter) {
                $query->where('name', 'like', "%{$filter}%");
            })
            ->orderBy('name', $order)
            ->get();

        return $castMembers
            ->map(fn (CastMember $castMember): CastMemberEntity => CastMemberEntity::fromModel($castMember))
            ->all();
    }

    public function paginate(string $filter = '', string $order = 'DESC', int $page = 1, int $perPage = 10): PaginationInterface
    {
        $castMembers = CastMember::query()
            ->when($filter, function ($query, string $filter) {
                $query->where('name', 'like', "%{$filter}%");
            })
            ->orderBy('name', $order)
            ->paginate(perPage: $perPage, page: $page);

        return new PaginationPresenter(
            $castMembers,
            fn (CastMember $castMember): CastMemberEntity => CastMemberEntity::fromModel($castMember),
        );
    }
}
