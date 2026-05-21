<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Enum\CodeExceptionEnum;

class ListGenreException extends \RuntimeException
{
    public function __construct(
        string $message = 'Erro ao listar Generos.',
        int $code = CodeExceptionEnum::ERROR_LIST_GENRES->value,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
