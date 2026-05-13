<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Entity;

use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Resolver\UuidResolver;
use App\Models\Category;
use DateTime;
use Illuminate\Support\Carbon;
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
        $this->assertSame('2024-01-01 10:30:00', $category->updatedAt());
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

    public function test_it_accepts_updated_at_as_datetime_inside_the_entity(): void
    {
        $updatedAt = new DateTime('2024-01-02 12:30:00');

        $category = new CategoryEntity(
            name: 'Movies',
            updatedAt: $updatedAt,
        );

        $this->assertSame($updatedAt, $category->updatedAt);
        $this->assertSame('2024-01-02 12:30:00', $category->updatedAt());
    }

    public function test_it_accepts_deleted_at_as_datetime_inside_the_entity(): void
    {
        $deletedAt = new DateTime('2024-01-03 14:30:00');

        $category = new CategoryEntity(
            name: 'Movies',
            deletedAt: $deletedAt,
        );

        $this->assertSame($deletedAt, $category->deletedAt);
        $this->assertSame('2024-01-03 14:30:00', $category->deletedAt());
    }

    public function test_it_marks_category_as_deleted(): void
    {
        $category = new CategoryEntity(
            name: 'Movies',
            createdAt: '2024-01-01 10:30:00',
            updatedAt: '2024-01-01 10:30:00',
        );

        $category->delete();

        $this->assertNotNull($category->deletedAt());
        $this->assertSame($category->deletedAt(), $category->updatedAt());
    }

    public function test_it_refreshes_updated_at_when_category_is_updated(): void
    {
        $category = new CategoryEntity(
            name: 'Movies',
            createdAt: '2024-01-01 10:30:00',
            updatedAt: '2024-01-01 10:30:00',
        );

        $category->update(
            name: 'Series',
            description: 'Updated description',
        );

        $this->assertSame('2024-01-01 10:30:00', $category->createdAt());
        $this->assertNotSame('2024-01-01 10:30:00', $category->updatedAt());
        $this->assertSame('Series', $category->name);
        $this->assertSame('Updated description', $category->description);
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

    public function test_it_creates_entity_from_model_with_nullable_description(): void
    {
        $id = (string) UuidResolver::random();

        $model = new Category;
        $model->setRawAttributes([
            'id' => $id,
            'name' => 'Documentaries',
            'description' => null,
            'is_active' => true,
            'created_at' => new Carbon('2026-05-13 10:00:00'),
            'updated_at' => new Carbon('2026-05-13 10:00:00'),
        ]);

        $category = CategoryEntity::fromModel($model);

        $this->assertSame($id, $category->id());
        $this->assertSame('', $category->description);
        $this->assertTrue($category->isActive);
    }
}
