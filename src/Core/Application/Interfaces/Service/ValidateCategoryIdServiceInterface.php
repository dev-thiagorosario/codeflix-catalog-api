<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Service;

interface ValidateCategoryIdServiceInterface
{
    public function validate(array $categoriesId): void;
}
