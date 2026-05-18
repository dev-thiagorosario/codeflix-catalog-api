<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Enum\CodeExceptionEnum;
use InvalidArgumentException;
use Throwable;

class InvalidJsendStatusException extends InvalidArgumentException
{
    public function __construct(
        string $status,
        int $code = CodeExceptionEnum::INVALID_JSEND_STATUS->value,
        ?Throwable $previous = null
    ) {
        parent::__construct("Invalid JSend status [{$status}].", $code, $previous);
    }
}
