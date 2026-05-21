<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Entity;

use App\Core\Domain\Entity\GenreEntity;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Exception\EntityValidationException;
use App\Models\Category;
use App\Models\Genre;
use DateTime;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;

class GenreEntityUnitTest extends TestCase
{
    public function test_it_exposes_attributes(): void
    {
        $uuid = (string) UuidResolver::random();
        $createdAt = new DateTime('2026-05-19 10:30:00');
        $updatedAt = new DateTime('2026-05-20 10:30:00');

        $genre = new GenreEntity(
            id: new UuidResolver($uuid),
            name: 'Genre 1',
            isActive: true,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );

        $this->assertSame($uuid, $genre->id());
        $this->assertSame('Genre 1', $genre->name);
        $this->assertTrue($genre->isActive);
        $this->assertSame($createdAt, $genre->createdAt);
        $this->assertSame($updatedAt, $genre->updatedAt);
        $this->assertSame('2026-05-19 10:30:00', $genre->createdAt());
        $this->assertSame('2026-05-20 10:30:00', $genre->updatedAt());
    }

    public function test_it_generates_default_id_and_timestamps(): void
    {
        $genre = new GenreEntity(
            name: 'Genre 1',
        );

        $this->assertTrue(RamseyUuid::isValid($genre->id()));
        $this->assertInstanceOf(DateTime::class, $genre->createdAt);
        $this->assertInstanceOf(DateTime::class, $genre->updatedAt);
        $this->assertSame($genre->createdAt(), $genre->updatedAt());
        $this->assertTrue($genre->isActive);
    }

    public function test_it_accepts_inactive_genre(): void
    {
        $genre = new GenreEntity(
            name: 'Genre 1',
            isActive: false,
        );

        $this->assertFalse($genre->isActive);
    }

    public function test_it_activates_genre(): void
    {
        $genre = new GenreEntity(
            name: 'Genre 1',
            isActive: false,
        );

        $genre->activate();

        $this->assertTrue($genre->isActive);
    }

    public function test_it_deactivates_genre(): void
    {
        $genre = new GenreEntity(
            name: 'Genre 1',
        );

        $genre->deactivate();

        $this->assertFalse($genre->isActive);
    }

    public function test_it_updates_name(): void
    {
        $genre = new GenreEntity(
            name: 'Genre 1',
            createdAt: new DateTime('2026-05-19 10:30:00'),
            updatedAt: new DateTime('2026-05-19 10:30:00'),
        );

        $genre->update('Updated Genre');

        $this->assertSame('Updated Genre', $genre->name);
        $this->assertNotSame('2026-05-19 10:30:00', $genre->updatedAt());
    }

    public function test_it_adds_category_id_to_genre(): void
    {
        $categoryId = (string) UuidResolver::random();

        $genre = new GenreEntity(
            name: 'Genre 1',
        );

        $genre->addCategory($categoryId);

        $this->assertSame([$categoryId], $genre->categoriesId);
    }

    public function test_it_accepts_category_ids_on_creation(): void
    {
        $firstCategoryId = (string) UuidResolver::random();
        $secondCategoryId = (string) UuidResolver::random();

        $genre = new GenreEntity(
            name: 'Genre 1',
            categoriesId: [$firstCategoryId, $secondCategoryId],
        );

        $this->assertSame([$firstCategoryId, $secondCategoryId], $genre->categoriesId);
    }

    public function test_it_keeps_category_ids_unique(): void
    {
        $categoryId = (string) UuidResolver::random();

        $genre = new GenreEntity(
            name: 'Genre 1',
            categoriesId: [$categoryId, $categoryId],
        );

        $genre->addCategory($categoryId);

        $this->assertSame([$categoryId], $genre->categoriesId);
    }

    public function test_it_removes_category_id_from_genre(): void
    {
        $firstCategoryId = (string) UuidResolver::random();
        $secondCategoryId = (string) UuidResolver::random();

        $genre = new GenreEntity(
            name: 'Genre 1',
        );

        $genre->addCategory($firstCategoryId);
        $genre->addCategory($secondCategoryId);
        $genre->removeCategory($firstCategoryId);

        $this->assertSame([$secondCategoryId], $genre->categoriesId);
    }

    public function test_it_keeps_categories_when_removing_unknown_category_id(): void
    {
        $categoryId = (string) UuidResolver::random();

        $genre = new GenreEntity(
            name: 'Genre 1',
        );

        $genre->addCategory($categoryId);
        $genre->removeCategory((string) UuidResolver::random());

        $this->assertSame([$categoryId], $genre->categoriesId);
    }

    public function test_it_creates_entity_from_model_with_loaded_categories(): void
    {
        $genreId = (string) UuidResolver::random();
        $firstCategoryId = (string) UuidResolver::random();
        $secondCategoryId = (string) UuidResolver::random();

        $model = new Genre;
        $model->setRawAttributes([
            'id' => $genreId,
            'name' => 'Action',
            'is_active' => false,
            'created_at' => new Carbon('2026-05-20 10:00:00'),
            'updated_at' => new Carbon('2026-05-20 11:00:00'),
            'deleted_at' => new Carbon('2026-05-20 12:00:00'),
        ]);

        $firstCategory = new Category;
        $firstCategory->setRawAttributes(['id' => $firstCategoryId]);

        $secondCategory = new Category;
        $secondCategory->setRawAttributes(['id' => $secondCategoryId]);

        $model->setRelation('categories', new EloquentCollection([
            $firstCategory,
            $secondCategory,
        ]));

        $genre = GenreEntity::fromModel($model);

        $this->assertSame($genreId, $genre->id());
        $this->assertSame('Action', $genre->name);
        $this->assertFalse($genre->isActive);
        $this->assertSame([$firstCategoryId, $secondCategoryId], $genre->categoriesId);
        $this->assertSame('2026-05-20 10:00:00', $genre->createdAt());
        $this->assertSame('2026-05-20 11:00:00', $genre->updatedAt());
        $this->assertSame('2026-05-20 12:00:00', $genre->deletedAt());
    }

    public function test_it_creates_entity_from_model_without_loaded_categories(): void
    {
        $genreId = (string) UuidResolver::random();

        $model = new Genre;
        $model->setRawAttributes([
            'id' => $genreId,
            'name' => 'Action',
            'is_active' => true,
            'created_at' => new Carbon('2026-05-20 10:00:00'),
            'updated_at' => new Carbon('2026-05-20 11:00:00'),
        ]);

        $genre = GenreEntity::fromModel($model);

        $this->assertSame($genreId, $genre->id());
        $this->assertTrue($genre->isActive);
        $this->assertSame([], $genre->categoriesId);
        $this->assertNull($genre->deletedAt());
    }

    public function test_it_rejects_names_shorter_than_three_characters(): void
    {
        $this->expectException(EntityValidationException::class);
        $this->expectExceptionMessage('The value must be at least 3 characters');

        new GenreEntity(
            name: 'Ge',
        );
    }

    public function test_it_rejects_blank_names(): void
    {
        $this->expectException(EntityValidationException::class);
        $this->expectExceptionMessage('Should not be empty or null');

        new GenreEntity(
            name: '   ',
        );
    }

    public function test_it_rejects_names_longer_than_255_characters(): void
    {
        $this->expectException(EntityValidationException::class);
        $this->expectExceptionMessage('The value must not be greater than 255 characters');

        new GenreEntity(
            name: str_repeat('a', 256),
        );
    }
}
