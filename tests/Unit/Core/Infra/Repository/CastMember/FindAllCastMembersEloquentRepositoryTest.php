<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\CastMember;

use App\Core\Domain\Entity\CastMemberEntity;
use App\Core\Domain\Repository\PaginationInterface;
use App\Core\Enum\CastMemberTypeEnum;
use App\Core\Infra\Repositories\EloquentRepository\CastMember\FindAllCastMembersEloquentRepository;
use App\Models\CastMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FindAllCastMembersEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_finds_all_cast_members_ordered_by_name_desc(): void
    {
        CastMember::factory()->create(['name' => 'Alpha Artist']);
        CastMember::factory()->create(['name' => 'Streaming Artist']);
        CastMember::factory()->create(['name' => 'Zeta Artist']);

        $repository = new FindAllCastMembersEloquentRepository;

        $result = $repository->findAll();

        $this->assertContainsOnlyInstancesOf(CastMemberEntity::class, $result);
        $this->assertSame(['Zeta Artist', 'Streaming Artist', 'Alpha Artist'], array_map(
            fn (CastMemberEntity $castMember): string => $castMember->name,
            $result,
        ));
    }

    public function test_it_filters_cast_members_by_name_and_orders_results(): void
    {
        CastMember::factory()->create(['name' => 'Ana Director']);
        CastMember::factory()->create(['name' => 'Bruno Actor']);
        CastMember::factory()->create(['name' => 'Zoe Director']);

        $repository = new FindAllCastMembersEloquentRepository;

        $result = $repository->findAll(filter: 'Director', order: 'ASC');

        $this->assertContainsOnlyInstancesOf(CastMemberEntity::class, $result);
        $this->assertSame(['Ana Director', 'Zoe Director'], array_map(
            fn (CastMemberEntity $castMember): string => $castMember->name,
            $result,
        ));
    }

    public function test_it_paginates_filtered_cast_members(): void
    {
        CastMember::factory()->create([
            'name' => 'Ana Director',
            'type' => CastMemberTypeEnum::DIRECTOR->value,
        ]);
        CastMember::factory()->create(['name' => 'Bruno Actor']);
        CastMember::factory()->create(['name' => 'Zoe Director']);

        $repository = new FindAllCastMembersEloquentRepository;

        $result = $repository->paginate(filter: 'Director', order: 'ASC', page: 1, perPage: 1);

        $this->assertInstanceOf(PaginationInterface::class, $result);
        $this->assertSame(2, $result->total());
        $this->assertSame(1, $result->currentPage());
        $this->assertSame(2, $result->lastPage());
        $this->assertSame(1, $result->perPage());
        $this->assertSame(1, $result->from());
        $this->assertSame(1, $result->to());
        $this->assertContainsOnlyInstancesOf(CastMemberEntity::class, $result->items());
        $this->assertSame('Ana Director', $result->items()[0]->name);
        $this->assertSame(CastMemberTypeEnum::DIRECTOR, $result->items()[0]->type);
    }
}
