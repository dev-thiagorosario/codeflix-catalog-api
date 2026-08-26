<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Provider;

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
use Tests\TestCase;

class CastMemberServiceProviderTest extends TestCase
{
    public function test_it_registers_cast_member_bindings(): void
    {
        $this->assertInstanceOf(
            CastMemberGatewayRepository::class,
            $this->app->make(CastMemberRepositoryInterface::class),
        );

        $this->assertInstanceOf(
            CreateCastMemberDataAdapter::class,
            $this->app->make(CreateCastMemberDataAdapterInterface::class),
        );

        $this->assertInstanceOf(
            ListCastMembersDataAdapter::class,
            $this->app->make(ListCastMembersDataAdapterInterface::class),
        );

        $this->assertInstanceOf(
            UpdateCastMemberDataAdapter::class,
            $this->app->make(UpdateCastMemberDataAdapterInterface::class),
        );

        $this->assertInstanceOf(
            CreateCastMemberUsecase::class,
            $this->app->make(CreateCastMemberUsecaseInterface::class),
        );

        $this->assertInstanceOf(
            DeleteCastMemberUsecase::class,
            $this->app->make(DeleteCastMemberUsecaseInterface::class),
        );

        $this->assertInstanceOf(
            ListCastMemberUsecase::class,
            $this->app->make(ListCastMemberUsecaseInterface::class),
        );

        $this->assertInstanceOf(
            ListCastMembersUsecase::class,
            $this->app->make(ListCastMembersUsecaseInterface::class),
        );

        $this->assertInstanceOf(
            UpdateCastMemberUsecase::class,
            $this->app->make(UpdateCastMemberUsecaseInterface::class),
        );
    }
}
