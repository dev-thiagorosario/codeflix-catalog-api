<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\Genre;

use App\Core\Domain\Entity\GenreEntity;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Infra\Repositories\EloquentRepository\Genre\CreateGenreEloquentRepository;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateGenreEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_genre(): void
    {
        $genre = new GenreEntity(
            id: UuidResolver::random(),
            name: 'Action',
            isActive: true,
        );

        $repository = new CreateGenreEloquentRepository;

        $result = $repository->insert($genre);

        $this->assertSame($genre->id(), $result->id());
        $this->assertSame('Action', $result->name);
        $this->assertTrue($result->isActive);

        $this->assertDatabaseHas(Genre::class, [
            'id' => $genre->id(),
            'name' => 'Action',
            'is_active' => true,
        ]);
    }
}
