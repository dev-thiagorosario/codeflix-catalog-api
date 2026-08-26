<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\CastMember;

use App\Core\Domain\Entity\CastMemberEntity;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Enum\CastMemberTypeEnum;
use App\Core\Infra\Repositories\EloquentRepository\CastMember\CreateCastMemberEloquentRepository;
use App\Models\CastMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCastMemberEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_cast_member(): void
    {
        $castMember = new CastMemberEntity(
            id: UuidResolver::random(),
            name: 'Christopher Nolan',
            type: CastMemberTypeEnum::DIRECTOR,
        );

        $repository = new CreateCastMemberEloquentRepository;

        $result = $repository->insert($castMember);

        $this->assertSame($castMember->id(), $result->id());
        $this->assertSame('Christopher Nolan', $result->name);
        $this->assertSame(CastMemberTypeEnum::DIRECTOR, $result->type);

        $this->assertDatabaseHas(CastMember::class, [
            'id' => $castMember->id(),
            'name' => 'Christopher Nolan',
            'type' => CastMemberTypeEnum::DIRECTOR->value,
        ]);
    }
}
