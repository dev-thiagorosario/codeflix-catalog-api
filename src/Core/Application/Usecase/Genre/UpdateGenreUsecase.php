<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Genre;

use App\Core\Application\DTO\Genre\UpdateGenreInputDTO;
use App\Core\Application\DTO\Genre\UpdateGenreOutputDTO;
use App\Core\Application\Interfaces\Service\ValidateCategoryIdServiceInterface;
use App\Core\Application\Interfaces\TransactionInterface;
use App\Core\Application\Interfaces\Usecase\Genre\UpdateGenreUsecaseInterface;
use App\Core\Domain\Repository\GenreRepositoryInterface;
use App\Core\Exception\GenreNotFoundException;

final class UpdateGenreUsecase implements UpdateGenreUsecaseInterface
{
    public function __construct(
        private readonly GenreRepositoryInterface $repository,
        private readonly ValidateCategoryIdServiceInterface $service,
        private readonly TransactionInterface $transaction
    ) {}

    public function __invoke(UpdateGenreInputDTO $input): UpdateGenreOutputDTO
    {
        $genre = $this->repository->findById($input->id);

        if ($genre === null) {
            throw new GenreNotFoundException;
        }
        try {
            $genre->update(
                $input->name
            );

            if ($input->isActive !== null) {
                $input->isActive
                    ? $genre->activate()
                    : $genre->deactivate();
            }

            $categoriesIdsToAdd = $input->categoriesIdsToAdd ?? [];

            foreach ($categoriesIdsToAdd as $categoryId) {
                $genre->addCategory($categoryId);
            }

            foreach ($input->categoriesIdsToRemove ?? [] as $categoryId) {
                $genre->removeCategory($categoryId);
            }

            $this->service->validate($categoriesIdsToAdd);

            $genreUpdated = $this->repository->update($genre);

            $this->transaction->commit();

            return new UpdateGenreOutputDTO(
                id: $genreUpdated->id(),
                name: $genreUpdated->name,
                isActive: $genreUpdated->isActive,
                updatedAt: $genreUpdated->updatedAt(),
            );

        } catch (\Exception $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}
