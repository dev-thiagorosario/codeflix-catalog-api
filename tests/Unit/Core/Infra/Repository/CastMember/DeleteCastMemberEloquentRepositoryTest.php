<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\CastMember;

use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Infra\Repositories\EloquentRepository\CastMember\DeleteCastMemberEloquentRepository;
use App\Models\CastMember;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCastMemberEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_a_cast_member(): void
    {
        $castMember = CastMember::factory()->create();

        $repository = new DeleteCastMemberEloquentRepository;

        $repository->delete($castMember->id);

        $this->assertSoftDeleted(CastMember::class, [
            'id' => $castMember->id,
        ]);
    }

    public function test_it_throws_exception_when_cast_member_does_not_exist(): void
    {
        $repository = new DeleteCastMemberEloquentRepository;

        $this->expectException(ModelNotFoundException::class);

        $repository->delete((string) UuidResolver::random());
    }
}
