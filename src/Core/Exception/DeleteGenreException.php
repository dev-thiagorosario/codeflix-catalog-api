<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Enum\CodeExceptionEnum;

class DeleteGenreException extends \RuntimeException
{
    public function __construct(
        string $message = 'Erro ao deletar Genero.',
        int $code = CodeExceptionEnum::ERROR_DELETE_GENRE->value,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
