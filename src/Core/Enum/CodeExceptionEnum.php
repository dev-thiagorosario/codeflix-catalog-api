<?php

declare(strict_types=1);

namespace App\Core\Enum;

enum CodeExceptionEnum: int
{
    case ENTITY_VALIDATION = 1003;
    case CATEGORY_NOT_FOUND = 1004;
}
