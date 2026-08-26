<?php

namespace Tests\Feature;

use App\Core\Enum\CastMemberTypeEnum;
use App\Models\CastMember;
use Database\Seeders\CastMemberSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Tests\TestCase;

class CastMemberSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_cast_member_factory_creates_a_valid_cast_member(): void
    {
        $castMember = CastMember::factory()->create();

        $this->assertTrue(RamseyUuid::isValid($castMember->id));
        $this->assertNotEmpty($castMember->name);
        $this->assertInstanceOf(CastMemberTypeEnum::class, $castMember->type);

        $this->assertDatabaseHas(CastMember::class, [
            'id' => $castMember->id,
            'name' => $castMember->name,
            'type' => $castMember->type->value,
        ]);
    }

    public function test_cast_member_seeder_creates_cast_members(): void
    {
        $this->seed(CastMemberSeeder::class);

        $this->assertDatabaseCount('cast_members', 10);
        $this->assertDatabaseHas(CastMember::class, [
            'name' => 'John Doe',
            'type' => CastMemberTypeEnum::DIRECTOR->value,
        ]);
    }
}
