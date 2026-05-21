<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Genre;

use App\Core\Application\DTO\Genre\ListGenreInputDTO;
use App\Core\Application\DTO\Genre\ListGenreOutputDTO;
use App\Core\Application\Interfaces\Usecase\Genre\ListGenreUsecaseInterface;
use App\Core\Domain\Repository\GenreRepositoryInterface;
use App\Core\Exception\GenreNotFoundException;

final class ListGenreUsecase implements ListGenreUsecaseInterface
{
    public function __construct(
        private readonly GenreRepositoryInterface $repository,
    ) {}

    public function __invoke(ListGenreInputDTO $input): ListGenreOutputDTO
    {
        $genre = $this->repository->findById(id: $input->id);

        if ($genre === null) {
            throw new GenreNotFoundException;
        }

        return new ListGenreOutputDTO(
            id: $genre->id(),
            name: $genre->name,
            isActive: $genre->isActive,
            createdAt: $genre->createdAt(),
        );
    }
}
