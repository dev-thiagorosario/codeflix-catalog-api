<?php

declare(strict_types=1);

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\CastMemberEntity;


interface CastMemberRepositoryInterface
{
    public function insert(CastMemberEntity $castMember): CastMemberEntity;

    public function findById(string $id): ?CastMemberEntity;

    public function findAll(string $filter = '', string $order = 'DESC'): array;

    public function paginate(string $filter = '', string $order = 'DESC', int $page = 1, int $perPage = 10): PaginationInterface;

    public function update(CastMemberEntity $castMember): CastMemberEntity;

    public function delete(string $id): void;
}
