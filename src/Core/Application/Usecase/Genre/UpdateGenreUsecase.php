<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Genre;

use App\Core\Application\DTO\Genre\UpdateGenreInputDTO;
use App\Core\Application\DTO\Genre\UpdateGenreOutputDTO;
use App\Core\Domain\Repository\GenreRepositoryInterface;
use App\Core\Exception\GenreNotFoundException;

final class UpdateGenreUsecase implements UpdateGenreUsecaseInterface
{
    public function __construct(
        private readonly GenreRepositoryInterface $repository
    ) {}

    public function __invoke(UpdateGenreInputDTO $input): UpdateGenreOutputDTO
    {
        $genre = $this->repository->findById($input->id);

        if ($genre === null) {
            throw new GenreNotFoundException;
        }

        $genre->update($input->name);

        if ($input->isActive !== null) {
            $input->isActive
                ? $genre->activate()
                : $genre->deactivate();
        }

        $genreUpdated = $this->repository->update($genre);

        return new UpdateGenreOutputDTO(
            id: $genreUpdated->id(),
            name: $genreUpdated->name,
            isActive: $genreUpdated->isActive,
            updatedAt: $genreUpdated->updatedAt(),
        );
    }
}
