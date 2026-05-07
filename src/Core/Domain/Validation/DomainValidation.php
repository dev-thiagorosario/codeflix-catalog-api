<?php

declare(strict_types=1);

namespace App\Core\Domain\Validation;

use App\Core\Exception\EntityValidationException;

class DomainValidation
{
    public static function notNull(string $value, ?string $exceptMessage = null): void
    {
        if (trim($value) === '') {
            throw new EntityValidationException($exceptMessage ?? 'Should not be empty or null');
        }
    }

    public static function strMaxLength(string $value, int $length = 255, ?string $exceptMessage = null): void
    {
        if (mb_strlen($value) > $length) {
            throw new EntityValidationException($exceptMessage ?? "The value must not be greater than {$length} characters");
        }
    }

    public static function strMinLength(string $value, int $length = 3, ?string $exceptMessage = null): void
    {
        if (mb_strlen($value) < $length) {
            throw new EntityValidationException($exceptMessage ?? "The value must be at least {$length} characters");
        }
    }

    public static function strCanNullAndMaxLength(string $value = '', int $length = 255, ?string $exceptMessage = null): void
    {
        if ($value !== '' && mb_strlen($value) > $length) {
            throw new EntityValidationException($exceptMessage ?? "The value must not be greater than {$length} characters");
        }
    }
}
