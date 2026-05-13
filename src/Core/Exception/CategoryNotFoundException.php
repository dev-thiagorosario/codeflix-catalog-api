<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Enum\CodeExceptionEnum;
use RuntimeException;
use Throwable;

class CategoryNotFoundException extends RuntimeException
{
    public function __construct(
        string $message = 'Categoria Não Encontrada',
        int $code = CodeExceptionEnum::CATEGORY_NOT_FOUND->value,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
