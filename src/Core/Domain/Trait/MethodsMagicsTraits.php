<?php

declare(strict_types=1);

namespace App\Core\Domain\Trait;

use OutOfBoundsException;

trait MethodsMagicsTraits
{
    public function __get(string $property): mixed
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        throw new OutOfBoundsException("Property {$property} not found in class ".static::class);
    }

    public function id(): string
    {
        return (string) $this->id;
    }

    public function createdAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

    public function updatedAt(): string
    {
        return $this->updatedAt->format('Y-m-d H:i:s');
    }

    public function deletedAt(): ?string
    {
        return $this->deletedAt?->format('Y-m-d H:i:s');
    }
}
