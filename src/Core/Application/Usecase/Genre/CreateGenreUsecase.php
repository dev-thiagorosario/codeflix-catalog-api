<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Genre;

use App\Core\Application\DTO\Genre\CreateGenreInputDTO;
use App\Core\Application\DTO\Genre\CreateGenreOutputDTO;
use App\Core\Application\Interfaces\Genre\CreateGenreUsecaseInterface;
use App\Core\Domain\Entity\GenreEntity;
use App\Core\Domain\Repository\GenreRepositoryInterface;

final class CreateGenreUsecase implements CreateGenreUsecaseInterface
{
    public function __construct(
        private readonly GenreRepositoryInterface $repository
    ) {}

    public function __invoke(CreateGenreInputDTO $input): CreateGenreOutputDTO
    {
        $genre = new GenreEntity(
            name: $input->name,
            isActive: $input->isActive,
        );

        $genreCreated = $this->repository->insert($genre);

        return new CreateGenreOutputDTO(
            id: $genreCreated->id(),
            name: $genreCreated->name,
            isActive: $genreCreated->isActive,
            createdAt: $genreCreated->createdAt(),
        );
    }
}
