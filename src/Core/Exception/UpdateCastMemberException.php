<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Enum\CodeExceptionEnum;
use RuntimeException;
use Throwable;

class UpdateCastMemberException extends RuntimeException
{
    public function __construct(
        string $message = 'Erro ao atualizar membro do elenco.',
        int $code = CodeExceptionEnum::ERROR_UPDATE_CAST_MEMBER->value,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
