<?php

declare(strict_types=1);

namespace App\Core\Infra\Provider;

use App\Core\Application\Interfaces\Adapter\CastMember\CreateCastMemberDataAdapterInterface;
use App\Core\Application\Interfaces\Adapter\CastMember\ListCastMembersDataAdapterInterface;
use App\Core\Application\Interfaces\Adapter\CastMember\UpdateCastMemberDataAdapterInterface;
use App\Core\Application\Interfaces\Usecase\CastMember\CreateCastMemberUsecaseInterface;
use App\Core\Application\Interfaces\Usecase\CastMember\DeleteCastMemberUsecaseInterface;
use App\Core\Application\Interfaces\Usecase\CastMember\ListCastMembersUsecaseInterface;
use App\Core\Application\Interfaces\Usecase\CastMember\ListCastMemberUsecaseInterface;
use App\Core\Application\Interfaces\Usecase\CastMember\UpdateCastMemberUsecaseInterface;
use App\Core\Application\Usecase\CastMember\CreateCastMemberUsecase;
use App\Core\Application\Usecase\CastMember\DeleteCastMemberUsecase;
use App\Core\Application\Usecase\CastMember\ListCastMembersUsecase;
use App\Core\Application\Usecase\CastMember\ListCastMemberUsecase;
use App\Core\Application\Usecase\CastMember\UpdateCastMemberUsecase;
use App\Core\Domain\Repository\CastMemberRepositoryInterface;
use App\Core\Infra\Adapter\CastMember\CreateCastMemberDataAdapter;
use App\Core\Infra\Adapter\CastMember\ListCastMembersDataAdapter;
use App\Core\Infra\Adapter\CastMember\UpdateCastMemberDataAdapter;
use App\Core\Infra\Repositories\Gateway\CastMemberGatewayRepository;
use Illuminate\Support\ServiceProvider;

class CastMemberServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CastMemberRepositoryInterface::class, CastMemberGatewayRepository::class);

        $this->app->bind(CreateCastMemberDataAdapterInterface::class, CreateCastMemberDataAdapter::class);
        $this->app->bind(ListCastMembersDataAdapterInterface::class, ListCastMembersDataAdapter::class);
        $this->app->bind(UpdateCastMemberDataAdapterInterface::class, UpdateCastMemberDataAdapter::class);

        $this->app->bind(CreateCastMemberUsecaseInterface::class, CreateCastMemberUsecase::class);
        $this->app->bind(DeleteCastMemberUsecaseInterface::class, DeleteCastMemberUsecase::class);
        $this->app->bind(ListCastMembersUsecaseInterface::class, ListCastMembersUsecase::class);
        $this->app->bind(ListCastMemberUsecaseInterface::class, ListCastMemberUsecase::class);
        $this->app->bind(UpdateCastMemberUsecaseInterface::class, UpdateCastMemberUsecase::class);
    }

    public function boot(): void {}
}
