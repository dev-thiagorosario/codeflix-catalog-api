<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Genre;

use App\Core\Application\DTO\Genre\ListGenresInputDTO;
use App\Core\Application\DTO\Genre\ListGenresOutputDTO;
use App\Core\Application\Interfaces\Usecase\Genre\ListGenresUsecaseInterface;
use App\Core\Domain\Entity\GenreEntity;
use App\Core\Domain\Repository\GenreRepositoryInterface;

final class ListGenresUsecase implements ListGenresUsecaseInterface
{
    public function __construct(
        private readonly GenreRepositoryInterface $repository
    ) {}

    public function __invoke(ListGenresInputDTO $input): ListGenresOutputDTO
    {
        $genres = $this->repository->paginate(
            filter: $input->name ?? '',
            order: $input->order,
            page: $input->page ?? 1,
            perPage: $input->perPage ?? 10,
        );

        return new ListGenresOutputDTO(
            items: array_map(
                fn (GenreEntity $genre): array => [
                    'id' => $genre->id(),
                    'name' => $genre->name,
                    'isActive' => $genre->isActive,
                    'createdAt' => $genre->createdAt(),
                ],
                $genres->items()
            ),
            total: $genres->total(),
            currentPage: $genres->currentPage(),
            lastPage: $genres->lastPage(),
            perPage: $genres->perPage(),
        );
    }
}
