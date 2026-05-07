<?php

declare(strict_types=1);

namespace App\Core\Exception;

use Exception;
use App\Core\Enum\CodeExceptionEnum;
use Throwable;

class EntityValidationException extends Exception
{
    public function __construct(
        string $message = '',
        int $code = CodeExceptionEnum::ENTITY_VALIDATION->value,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
