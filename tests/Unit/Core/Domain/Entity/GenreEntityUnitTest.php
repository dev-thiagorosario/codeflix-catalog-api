<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Entity;

use App\Core\Domain\Entity\GenreEntity;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Exception\EntityValidationException;
use DateTime;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;

class GenreEntityUnitTest extends TestCase
{
    public function test_it_exposes_attributes(): void
    {
        $uuid = (string) UuidResolver::random();
        $createdAt = new DateTime('2026-05-19 10:30:00');

        $genre = new GenreEntity(
            id: new UuidResolver($uuid),
            name: 'Genre 1',
            isActive: true,
            createdAt: $createdAt,
        );

        $this->assertSame($uuid, $genre->id());
        $this->assertSame('Genre 1', $genre->name);
        $this->assertTrue($genre->isActive);
        $this->assertSame($createdAt, $genre->createdAt);
        $this->assertSame('2026-05-19 10:30:00', $genre->createdAt());
    }

    public function test_it_generates_default_id_and_created_at(): void
    {
        $genre = new GenreEntity(
            name: 'Genre 1',
        );

        $this->assertTrue(RamseyUuid::isValid($genre->id()));
        $this->assertInstanceOf(DateTime::class, $genre->createdAt);
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
        );

        $genre->update('Updated Genre');

        $this->assertSame('Updated Genre', $genre->name);
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
