<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Adapter\CastMember;

use App\Core\Application\DTO\CastMember\UpdateCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\UpdateCastMemberOutputDTO;
use App\Core\Infra\Adapter\CastMember\UpdateCastMemberDataAdapter;
use PHPUnit\Framework\TestCase;

class UpdateCastMemberDataAdapterTest extends TestCase
{
    public function test_it_converts_array_to_input_dto(): void
    {
        $adapter = new UpdateCastMemberDataAdapter;

        $input = $adapter->fromArray([
            'id' => 'cast-member-id',
            'name' => 'Greta Gerwig',
            'type' => '1',
        ]);

        $this->assertInstanceOf(UpdateCastMemberInputDTO::class, $input);
        $this->assertSame('cast-member-id', $input->id);
        $this->assertSame('Greta Gerwig', $input->name);
        $this->assertSame(1, $input->type);
    }

    public function test_it_converts_output_dto_to_array(): void
    {
        $adapter = new UpdateCastMemberDataAdapter;

        $result = $adapter->toArray(new UpdateCastMemberOutputDTO(
            id: 'cast-member-id',
            name: 'Greta Gerwig',
            type: 1,
            createdAt: '2026-08-25 10:00:00',
        ));

        $this->assertSame([
            'id' => 'cast-member-id',
            'name' => 'Greta Gerwig',
            'type' => 1,
            'created_at' => '2026-08-25 10:00:00',
        ], $result);
    }
}
