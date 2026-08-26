<?php

use App\Core\Infra\Provider\CastMemberServiceProvider;
use App\Core\Infra\Provider\CategoryServiceProvider;
use App\Core\Infra\Provider\GenreServiceProvider;
use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    CategoryServiceProvider::class,
    GenreServiceProvider::class,
    CastMemberServiceProvider::class,
];
