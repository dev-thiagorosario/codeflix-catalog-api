<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Genre;

use App\Core\Application\DTO\Genre\DeleteGenreInputDTO;
use App\Core\Application\Interfaces\Genre\DeleteGenreUsecaseInterface;
use App\Core\Domain\Repository\GenreRepositoryInterface;
use App\Core\Exception\GenreNotFoundException;

final class DeleteGenreUsecase implements DeleteGenreUsecaseInterface
{
    public function __construct(
        private readonly GenreRepositoryInterface $repository
    ) {}

    public function __invoke(DeleteGenreInputDTO $input): void
    {
        $genre = $this->repository->findById($input->id);

        if ($genre === null) {
            throw new GenreNotFoundException;
        }

        $this->repository->delete($input->id);
    }
}
