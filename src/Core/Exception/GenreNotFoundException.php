<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Enum\CodeExceptionEnum;
use RuntimeException;
use Throwable;

class GenreNotFoundException extends RuntimeException
{
    public function __construct(
        string $message = 'Gênero Não Encontrado',
        int $code = CodeExceptionEnum::GENRE_NOT_FOUND->value,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
