<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Enum\CodeExceptionEnum;
use InvalidArgumentException;
use Throwable;

class JsendErrorMessageRequiredException extends InvalidArgumentException
{
    public function __construct(
        string $message = 'JSend error responses require a message.',
        int $code = CodeExceptionEnum::JSEND_ERROR_MESSAGE_REQUIRED->value,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
