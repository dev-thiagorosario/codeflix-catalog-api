<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Enum\CodeExceptionEnum;
use RuntimeException;
use Throwable;

class ListCastMemberException extends RuntimeException
{
    public function __construct(
        string $message = 'Erro ao listar membros do elenco.',
        int $code = CodeExceptionEnum::ERROR_LIST_CAST_MEMBERS->value,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
