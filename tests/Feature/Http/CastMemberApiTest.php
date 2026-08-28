<?php

declare(strict_types=1);

namespace Tests\Feature\Http;

use App\Core\Enum\CastMemberTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CastMemberApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_executes_cast_member_crud_through_api_routes(): void
    {
        $createResponse = $this->postJson('/api/create-cast-member', [
            'name' => '  Christopher Nolan  ',
            'type' => CastMemberTypeEnum::DIRECTOR->value,
        ]);

        $createResponse
            ->assertCreated()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.name', 'Christopher Nolan')
            ->assertJsonPath('data.type', CastMemberTypeEnum::DIRECTOR->value);

        $castMemberId = $createResponse->json('data.id');

        $this->assertIsString($castMemberId);
        $this->assertDatabaseHas('cast_members', [
            'id' => $castMemberId,
            'name' => 'Christopher Nolan',
            'type' => CastMemberTypeEnum::DIRECTOR->value,
        ]);

        $this->getJson('/api/list-cast-members?name=Christopher&order=asc')
            ->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.items.0.id', $castMemberId)
            ->assertJsonPath('data.meta.total', 1);

        $this->putJson("/api/update-cast-member/{$castMemberId}", [
            'name' => 'Jordan Peele',
            'type' => CastMemberTypeEnum::ACTOR->value,
        ])
            ->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.name', 'Jordan Peele')
            ->assertJsonPath('data.type', CastMemberTypeEnum::ACTOR->value);

        $this->deleteJson("/api/delete-cast-member/{$castMemberId}")
            ->assertOk()
            ->assertExactJson([
                'status' => 'success',
                'data' => [],
            ]);

        $this->assertSoftDeleted('cast_members', [
            'id' => $castMemberId,
        ]);
    }

    public function test_it_validates_cast_member_requests(): void
    {
        $this->postJson('/api/create-cast-member', [
            'name' => '',
            'type' => 999,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'type']);

        $this->putJson('/api/update-cast-member/not-a-uuid', [
            'name' => 'Jordan Peele',
            'type' => CastMemberTypeEnum::DIRECTOR->value,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['id']);
    }

    public function test_it_returns_not_found_when_mutating_unknown_cast_member(): void
    {
        $castMemberId = (string) Str::uuid();

        $this->putJson("/api/update-cast-member/{$castMemberId}", [
            'name' => 'Jordan Peele',
            'type' => CastMemberTypeEnum::DIRECTOR->value,
        ])
            ->assertNotFound()
            ->assertExactJson([
                'status' => 'error',
                'data' => [],
                'message' => 'Membro do elenco não encontrado',
                'code' => 1015,
            ]);

        $this->deleteJson("/api/delete-cast-member/{$castMemberId}")
            ->assertNotFound()
            ->assertExactJson([
                'status' => 'error',
                'data' => [],
                'message' => 'Membro do elenco não encontrado',
                'code' => 1015,
            ]);
    }
}
