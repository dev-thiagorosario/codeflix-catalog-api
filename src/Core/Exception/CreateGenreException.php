<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Enum\CodeExceptionEnum;

class CreateGenreException extends \RuntimeException
{
    public function __construct(
        string $message = 'Erro ao criar Genero.',
        int $code = CodeExceptionEnum::ERROR_CREATE_GENRE->value,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
