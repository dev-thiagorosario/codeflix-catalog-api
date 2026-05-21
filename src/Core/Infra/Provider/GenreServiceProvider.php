<?php

declare(strict_types=1);

namespace App\Core\Infra\Provider;

use App\Core\Application\Interfaces\Service\ValidateCategoryIdServiceInterface;
use App\Core\Application\Interfaces\TransactionInterface;
use App\Core\Application\Interfaces\Usecase\Genre\CreateGenreUsecaseInterface;
use App\Core\Application\Interfaces\Usecase\Genre\DeleteGenreUsecaseInterface;
use App\Core\Application\Interfaces\Usecase\Genre\ListGenresUsecaseInterface;
use App\Core\Application\Interfaces\Usecase\Genre\ListGenreUsecaseInterface;
use App\Core\Application\Interfaces\Usecase\Genre\UpdateGenreUsecaseInterface;
use App\Core\Application\Service\ValidateCategoryIdService;
use App\Core\Application\Usecase\Genre\CreateGenreUsecase;
use App\Core\Application\Usecase\Genre\DeleteGenreUsecase;
use App\Core\Application\Usecase\Genre\ListGenresUsecase;
use App\Core\Application\Usecase\Genre\ListGenreUsecase;
use App\Core\Application\Usecase\Genre\UpdateGenreUsecase;
use App\Core\Domain\Repository\GenreRepositoryInterface;
use App\Core\Infra\Repositories\DBTransaction\DBTransaction;
use App\Core\Infra\Repositories\Gateway\GenreGatewayRepository;
use Illuminate\Support\ServiceProvider;

class GenreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(GenreRepositoryInterface::class, GenreGatewayRepository::class);

        $this->app->bind(ValidateCategoryIdServiceInterface::class, ValidateCategoryIdService::class);
        $this->app->bind(TransactionInterface::class, DBTransaction::class);

        $this->app->bind(CreateGenreUsecaseInterface::class, CreateGenreUsecase::class);
        $this->app->bind(DeleteGenreUsecaseInterface::class, DeleteGenreUsecase::class);
        $this->app->bind(ListGenresUsecaseInterface::class, ListGenresUsecase::class);
        $this->app->bind(ListGenreUsecaseInterface::class, ListGenreUsecase::class);
        $this->app->bind(UpdateGenreUsecaseInterface::class, UpdateGenreUsecase::class);
    }

    public function boot(): void {}
}
