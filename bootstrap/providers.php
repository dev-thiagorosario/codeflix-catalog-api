<?php

use App\Core\Infra\Provider\CategoryServiceProvider;
use App\Providers\AppServiceProvider;
use App\Core\Infra\Provider\GenreServiceProvider;

return [
    AppServiceProvider::class,
    CategoryServiceProvider::class,
    GenreServiceProvider::class,
];
