<?php

namespace Tests\Unit\Core\Application\Usecase\Category;

use App\Core\Application\Usecase\Category\CreateCategoryUsecase;
use PHPUnit\Framework\TestCase;


class CreateCategoryUsecaseUnitTest extends TestCase
{
    public function testCreateNewCaegory(): void
    {
        new CreateCategoryUsecase();
    }
}
