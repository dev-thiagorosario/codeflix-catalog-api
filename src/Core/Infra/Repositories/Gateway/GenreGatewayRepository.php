<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\Gateway;

use App\Core\Domain\Entity\GenreEntity;
use App\Core\Domain\Repository\GenreRepositoryInterface;
use App\Core\Domain\Repository\PaginationInterface;
use App\Core\Infra\Repositories\EloquentRepository\Genre\CreateGenreEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\Genre\DeleteGenreEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\Genre\FindAllGenresEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\Genre\FindGenreByIdEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\Genre\UpdateGenreEloquentRepository;

final readonly class GenreGatewayRepository implements GenreRepositoryInterface
{
    public function __construct(
        private CreateGenreEloquentRepository $createGenreRepository,
        private FindGenreByIdEloquentRepository $findGenreByIdRepository,
        private FindAllGenresEloquentRepository $findAllGenresRepository,
        private UpdateGenreEloquentRepository $updateGenreRepository,
        private DeleteGenreEloquentRepository $deleteGenreRepository,
    ) {}

    public function insert(GenreEntity $genre): GenreEntity
    {
        return $this->createGenreRepository->insert($genre);
    }

    public function findById(string $id): ?GenreEntity
    {
        return $this->findGenreByIdRepository->findById($id);
    }

    /**
     * @return GenreEntity[]
     */
    public function findAll(string $filter = '', string $order = 'DESC'): array
    {
        return $this->findAllGenresRepository->findAll($filter, $order);
    }

    public function paginate(string $filter = '', string $order = 'DESC', int $page = 1, int $perPage = 10): PaginationInterface
    {
        return $this->findAllGenresRepository->paginate($filter, $order, $page, $perPage);
    }

    public function update(GenreEntity $genre): GenreEntity
    {
        return $this->updateGenreRepository->update($genre);
    }

    public function delete(string $id): bool
    {
        return $this->deleteGenreRepository->delete($id);
    }
}
