<?php

declare(strict_types=1);

namespace App\Core\Infra\Provider;

use App\Core\Application\Usecase\Category\CreateCategoryUsecase;
use App\Core\Application\Usecase\Category\CreateCategoryUsecaseInterface;
use App\Core\Application\Usecase\Category\DeleteCategoryUsecase;
use App\Core\Application\Usecase\Category\DeleteCategoryUsecaseInterface;
use App\Core\Application\Usecase\Category\ListCategoryUsecase;
use App\Core\Application\Usecase\Category\ListCategoryUsecaseInterface;
use App\Core\Application\Usecase\Category\UpdateCategoryUsecase;
use App\Core\Application\Usecase\Category\UpdateCategoryUsecaseInterface;
use App\Core\Domain\Repository\CategoryRepositoryInterface;
use App\Core\Infra\Adapter\Category\CreateCategoryDataAdapter;
use App\Core\Infra\Adapter\Category\CreateCategoryDataAdapterInterface;
use App\Core\Infra\Adapter\Category\ListCategoryDataAdapter;
use App\Core\Infra\Adapter\Category\ListCategoryDataAdapterInterface;
use App\Core\Infra\Repository\Category\CategoryEloquentRepository;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryEloquentRepository::class);

        $this->app->bind(CreateCategoryDataAdapterInterface::class, CreateCategoryDataAdapter::class);
        $this->app->bind(ListCategoryDataAdapterInterface::class, ListCategoryDataAdapter::class);

        $this->app->bind(CreateCategoryUsecaseInterface::class, CreateCategoryUsecase::class);
        $this->app->bind(DeleteCategoryUsecaseInterface::class, DeleteCategoryUsecase::class);
        $this->app->bind(ListCategoryUsecaseInterface::class, ListCategoryUsecase::class);
        $this->app->bind(UpdateCategoryUsecaseInterface::class, UpdateCategoryUsecase::class);
    }

    public function boot(): void {}
}
