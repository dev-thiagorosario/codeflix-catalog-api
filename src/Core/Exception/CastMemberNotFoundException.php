<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Enum\CodeExceptionEnum;
use RuntimeException;
use Throwable;

class CastMemberNotFoundException extends RuntimeException
{
    public function __construct(
        string $message = 'Membro do elenco não encontrado',
        int $code = CodeExceptionEnum::CAST_MEMBER_NOT_FOUND->value,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
