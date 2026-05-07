<?php

declare(strict_types=1);

namespace Tests\Unit\Core;

use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Resolver\UuidResolver;
use DateTime;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;

class CategoryEntityTest extends TestCase
{
    public function test_it_keeps_created_at_as_datetime_inside_the_entity(): void
    {
        $createdAt = new DateTime('2024-01-01 10:30:00');

        $category = new CategoryEntity(
            name: 'Movies',
            createdAt: $createdAt,
        );

        $this->assertSame($createdAt, $category->createdAt);
        $this->assertSame('2024-01-01 10:30:00', $category->createdAt());
    }

    public function test_it_still_accepts_string_dates_and_generates_valid_uuid(): void
    {
        $category = new CategoryEntity(
            name: 'Series',
            createdAt: '2024-01-01 10:30:00',
        );

        $this->assertInstanceOf(DateTime::class, $category->createdAt);
        $this->assertTrue(RamseyUuid::isValid($category->id()));
    }

    public function test_it_accepts_an_existing_uuid_resolver(): void
    {
        $id = UuidResolver::random();

        $category = new CategoryEntity(
            id: $id,
            name: 'Documentaries',
        );

        $this->assertSame((string) $id, $category->id());
    }
}
