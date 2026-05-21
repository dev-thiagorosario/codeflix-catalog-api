<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Enum\CodeExceptionEnum;
use Throwable;

class UpdateGenreException extends \RuntimeException
{
    public function __construct(
        string $message = 'Erro ao atualizar Genero.',
        int $code = CodeExceptionEnum::ERROR_UPDATE_GENRE->value,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
