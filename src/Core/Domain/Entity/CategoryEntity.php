<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity;

use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Domain\Trait\MethodsMagicsTraits;
use App\Core\Domain\Validation\DomainValidation;
use DateTime;

class CategoryEntity
{
    use MethodsMagicsTraits;

    public function __construct(
        protected UuidResolver|string|null $id = null,
        protected string $name = '',
        protected string $description = '',
        protected bool $isActive = true,
        protected DateTime|string|null $createdAt = null,
    ) {
        $this->id = $this->id ? new UuidResolver($this->id) : UuidResolver::random();

        $this->createdAt = $this->createdAt ? new DateTime($this->createdAt) : new DateTime();

        $this->validate();
    }

    public function activate(): void
    {
        $this->isActive = true;
    }
    public function disable(): void
    {
        $this->isActive = false;
    }

    public function update(string $name, string $description): void
    {
        $this->name = $name;
        $this->description = $description;

        $this->validate();
    }

    public function validate(): void
    {
        DomainValidation::notNull($this->name);
        DomainValidation::strMaxLength($this->name);
        DomainValidation::strMinLength($this->name);
        DomainValidation::strCanNullAndMaxLength($this->description);
    }
}
