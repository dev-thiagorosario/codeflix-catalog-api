<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Adapter\CastMember;

use App\Core\Application\DTO\CastMember\ListCastMembersInputDTO;
use App\Core\Application\DTO\CastMember\ListCastMembersOutputDTO;
use App\Core\Infra\Adapter\CastMember\ListCastMembersDataAdapter;
use PHPUnit\Framework\TestCase;

class ListCastMembersDataAdapterTest extends TestCase
{
    public function test_it_converts_array_to_input_dto(): void
    {
        $adapter = new ListCastMembersDataAdapter;

        $input = $adapter->fromArray([
            'name' => 'Nolan',
            'page' => '2',
            'per_page' => '10',
            'order' => 'ASC',
        ]);

        $this->assertInstanceOf(ListCastMembersInputDTO::class, $input);
        $this->assertSame('Nolan', $input->name);
        $this->assertSame(2, $input->page);
        $this->assertSame(10, $input->perPage);
        $this->assertSame('ASC', $input->order);
    }

    public function test_it_uses_defaults_when_optional_data_is_missing(): void
    {
        $adapter = new ListCastMembersDataAdapter;

        $input = $adapter->fromArray([]);

        $this->assertNull($input->name);
        $this->assertNull($input->page);
        $this->assertNull($input->perPage);
        $this->assertSame('DESC', $input->order);
    }

    public function test_it_converts_output_dto_to_array(): void
    {
        $adapter = new ListCastMembersDataAdapter;

        $result = $adapter->toArray(new ListCastMembersOutputDTO(
            items: [
                [
                    'id' => 'cast-member-id',
                    'name' => 'Christopher Nolan',
                    'type' => 1,
                    'createdAt' => '2026-08-25 10:00:00',
                ],
            ],
            total: 1,
            currentPage: 2,
            lastPage: 3,
            perPage: 10,
        ));

        $this->assertSame([
            'items' => [
                [
                    'id' => 'cast-member-id',
                    'name' => 'Christopher Nolan',
                    'type' => 1,
                    'created_at' => '2026-08-25 10:00:00',
                ],
            ],
            'meta' => [
                'total' => 1,
                'current_page' => 2,
                'last_page' => 3,
                'per_page' => 10,
            ],
        ], $result);
    }
}
