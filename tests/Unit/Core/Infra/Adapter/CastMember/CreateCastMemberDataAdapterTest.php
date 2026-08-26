<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Adapter\CastMember;

use App\Core\Application\DTO\CastMember\CreateCastMemberInputDTO;
use App\Core\Application\DTO\CastMember\CreateCastMemberOutputDTO;
use App\Core\Infra\Adapter\CastMember\CreateCastMemberDataAdapter;
use PHPUnit\Framework\TestCase;

class CreateCastMemberDataAdapterTest extends TestCase
{
    public function test_it_converts_array_to_input_dto(): void
    {
        $adapter = new CreateCastMemberDataAdapter;

        $input = $adapter->fromArray([
            'name' => 'Christopher Nolan',
            'type' => '1',
        ]);

        $this->assertInstanceOf(CreateCastMemberInputDTO::class, $input);
        $this->assertSame('Christopher Nolan', $input->name);
        $this->assertSame(1, $input->type);
    }

    public function test_it_converts_output_dto_to_array(): void
    {
        $adapter = new CreateCastMemberDataAdapter;

        $result = $adapter->toArray(new CreateCastMemberOutputDTO(
            id: 'cast-member-id',
            name: 'Christopher Nolan',
            type: 1,
            createdAt: '2026-08-25 10:00:00',
        ));

        $this->assertSame([
            'id' => 'cast-member-id',
            'name' => 'Christopher Nolan',
            'type' => 1,
            'created_at' => '2026-08-25 10:00:00',
        ], $result);
    }
}
