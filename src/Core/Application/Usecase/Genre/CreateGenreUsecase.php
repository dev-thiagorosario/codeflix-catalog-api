<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Genre;

use App\Core\Application\DTO\Genre\CreateGenreInputDTO;
use App\Core\Application\DTO\Genre\CreateGenreOutputDTO;
use App\Core\Application\Interfaces\Service\ValidateCategoryIdServiceInterface;
use App\Core\Application\Interfaces\TransactionInterface;
use App\Core\Application\Interfaces\Usecase\Genre\CreateGenreUsecaseInterface;
use App\Core\Domain\Entity\GenreEntity;
use App\Core\Domain\Repository\GenreRepositoryInterface;

final class CreateGenreUsecase implements CreateGenreUsecaseInterface
{
    public function __construct(
        private readonly GenreRepositoryInterface $repository,
        private readonly ValidateCategoryIdServiceInterface $service,
        private readonly TransactionInterface $transaction
    ) {}

    public function __invoke(CreateGenreInputDTO $input): CreateGenreOutputDTO
    {
        try {
            $genre = new GenreEntity(
                name: $input->name,
                isActive: $input->isActive,
                categoriesId: $input->categoriesId,
            );

            $this->service->validate($input->categoriesId);

            $genreCreated = $this->repository->insert($genre);

            $this->transaction->commit();

            return new CreateGenreOutputDTO(
                id: $genreCreated->id(),
                name: $genreCreated->name,
                isActive: $genreCreated->isActive,
                createdAt: $genreCreated->createdAt(),
            );
        } catch (\Exception $e) {

            $this->transaction->rollback();

            throw $e;
        }

    }
}
