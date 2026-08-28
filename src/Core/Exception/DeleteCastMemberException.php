<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Enum\CodeExceptionEnum;
use RuntimeException;
use Throwable;

class DeleteCastMemberException extends RuntimeException
{
    public function __construct(
        string $message = 'Erro ao deletar membro do elenco.',
        int $code = CodeExceptionEnum::ERROR_DELETE_CAST_MEMBER->value,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
