<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\CastMember;

use App\Core\Domain\Entity\CastMemberEntity;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Enum\CastMemberTypeEnum;
use App\Core\Infra\Repositories\EloquentRepository\CastMember\UpdateCastMemberEloquentRepository;
use App\Models\CastMember;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateCastMemberEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_a_cast_member(): void
    {
        $model = CastMember::factory()->create([
            'name' => 'Greta Gerwig',
            'type' => CastMemberTypeEnum::ACTOR->value,
        ]);

        $castMember = new CastMemberEntity(
            id: $model->id,
            name: 'Greta Gerwig Updated',
            type: CastMemberTypeEnum::DIRECTOR,
            createdAt: $model->created_at->format('Y-m-d H:i:s'),
        );

        $repository = new UpdateCastMemberEloquentRepository;

        $result = $repository->update($castMember);

        $this->assertSame($model->id, $result->id());
        $this->assertSame('Greta Gerwig Updated', $result->name);
        $this->assertSame(CastMemberTypeEnum::DIRECTOR, $result->type);

        $this->assertDatabaseHas(CastMember::class, [
            'id' => $model->id,
            'name' => 'Greta Gerwig Updated',
            'type' => CastMemberTypeEnum::DIRECTOR->value,
        ]);
    }

    public function test_it_throws_exception_when_cast_member_does_not_exist(): void
    {
        $castMember = new CastMemberEntity(
            id: UuidResolver::random(),
            name: 'Jordan Peele',
            type: CastMemberTypeEnum::DIRECTOR,
        );

        $repository = new UpdateCastMemberEloquentRepository;

        $this->expectException(ModelNotFoundException::class);

        $repository->update($castMember);
    }
}
