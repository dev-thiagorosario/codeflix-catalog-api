<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\CastMember;

use App\Core\Domain\Entity\CastMemberEntity;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Enum\CastMemberTypeEnum;
use App\Core\Infra\Repositories\EloquentRepository\CastMember\FindCastMemberByIdEloquentRepository;
use App\Models\CastMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FindCastMemberByIdEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_finds_a_cast_member_by_id(): void
    {
        $model = CastMember::factory()->create([
            'name' => 'Viola Davis',
            'type' => CastMemberTypeEnum::ACTOR->value,
        ]);

        $repository = new FindCastMemberByIdEloquentRepository;

        $result = $repository->findById($model->id);

        $this->assertInstanceOf(CastMemberEntity::class, $result);
        $this->assertSame($model->id, $result->id());
        $this->assertSame('Viola Davis', $result->name);
        $this->assertSame(CastMemberTypeEnum::ACTOR, $result->type);
        $this->assertSame($model->created_at->format('Y-m-d H:i:s'), $result->createdAt());
    }

    public function test_it_returns_null_when_cast_member_does_not_exist(): void
    {
        $repository = new FindCastMemberByIdEloquentRepository;

        $result = $repository->findById((string) UuidResolver::random());

        $this->assertNull($result);
    }
}
