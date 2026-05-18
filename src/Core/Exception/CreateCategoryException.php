<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Enum\CodeExceptionEnum;
use RuntimeException;

class CreateCategoryException extends RuntimeException
{
    public function __construct(
        string $message = 'Erro ao criar categoria.',
        int $code = CodeExceptionEnum::CREATE_CATEGORY_ERROR->value,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
