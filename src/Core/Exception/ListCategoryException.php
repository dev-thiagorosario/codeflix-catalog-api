<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Enum\CodeExceptionEnum;
use Throwable;

class ListCategoryException extends \RuntimeException
{
    public function __construct(
        string $message = 'Erro ao listar categorias.',
        int $code = CodeExceptionEnum::ERROR_LIST_CATEGORY->value,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
