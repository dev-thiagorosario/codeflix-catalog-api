<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Provider;

use App\Core\Application\Interfaces\Adapter\Genre\CreateGenreDataAdapterInterface;
use App\Core\Application\Interfaces\Adapter\Genre\ListGenresDataAdapterInterface;
use App\Core\Application\Interfaces\Adapter\Genre\UpdateGenreDataAdapterInterface;
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
use App\Core\Infra\Adapter\Genre\CreateGenreDataAdapter;
use App\Core\Infra\Adapter\Genre\ListGenresDataAdapter;
use App\Core\Infra\Adapter\Genre\UpdateGenreDataAdapter;
use App\Core\Infra\Repositories\DBTransaction\DBTransaction;
use App\Core\Infra\Repositories\Gateway\GenreGatewayRepository;
use Tests\TestCase;

class GenreServiceProviderTest extends TestCase
{
    public function test_it_registers_genre_bindings(): void
    {
        $this->assertInstanceOf(
            GenreGatewayRepository::class,
            $this->app->make(GenreRepositoryInterface::class)
        );

        $this->assertInstanceOf(
            ValidateCategoryIdService::class,
            $this->app->make(ValidateCategoryIdServiceInterface::class)
        );

        $this->assertInstanceOf(
            DBTransaction::class,
            $this->app->make(TransactionInterface::class)
        );

        $this->assertInstanceOf(
            CreateGenreDataAdapter::class,
            $this->app->make(CreateGenreDataAdapterInterface::class)
        );

        $this->assertInstanceOf(
            ListGenresDataAdapter::class,
            $this->app->make(ListGenresDataAdapterInterface::class)
        );

        $this->assertInstanceOf(
            UpdateGenreDataAdapter::class,
            $this->app->make(UpdateGenreDataAdapterInterface::class)
        );

        $this->assertInstanceOf(
            CreateGenreUsecase::class,
            $this->app->make(CreateGenreUsecaseInterface::class)
        );

        $this->assertInstanceOf(
            DeleteGenreUsecase::class,
            $this->app->make(DeleteGenreUsecaseInterface::class)
        );

        $this->assertInstanceOf(
            ListGenresUsecase::class,
            $this->app->make(ListGenresUsecaseInterface::class)
        );

        $this->assertInstanceOf(
            ListGenreUsecase::class,
            $this->app->make(ListGenreUsecaseInterface::class)
        );

        $this->assertInstanceOf(
            UpdateGenreUsecase::class,
            $this->app->make(UpdateGenreUsecaseInterface::class)
        );
    }
}
