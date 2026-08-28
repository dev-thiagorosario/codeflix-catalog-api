<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Enum\CodeExceptionEnum;
use RuntimeException;
use Throwable;

class CreateCastMemberException extends RuntimeException
{
    public function __construct(
        string $message = 'Erro ao criar membro do elenco.',
        int $code = CodeExceptionEnum::ERROR_CREATE_CAST_MEMBER->value,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
