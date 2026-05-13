<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity;

use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Domain\Trait\MethodsMagicsTraits;
use App\Core\Domain\Validation\DomainValidation;
use DateTime;

/**
 * @property-read string $name
 * @property-read string $description
 * @property-read bool $isActive
 * @property-read DateTime $createdAt
 * @property-read DateTime $updatedAt
 * @property-read DateTime|null $deletedAt
 */
class CategoryEntity
{
    use MethodsMagicsTraits;

    public function __construct(
        protected UuidResolver|string|null $id = null,
        protected string $name = '',
        protected string $description = '',
        protected bool $isActive = true,
        protected DateTime|string|null $createdAt = null,
        protected DateTime|string|null $updatedAt = null,
        protected DateTime|string|null $deletedAt = null,
    ) {
        $this->id = match (true) {
            $this->id instanceof UuidResolver => $this->id,
            is_string($this->id) => new UuidResolver($this->id),
            default => UuidResolver::random(),
        };

        $this->createdAt = $this->createdAt instanceof DateTime
            ? $this->createdAt
            : new DateTime($this->createdAt ?: 'now');

        $this->updatedAt = $this->updatedAt instanceof DateTime
            ? $this->updatedAt
            : new DateTime($this->updatedAt ?: $this->createdAt->format('Y-m-d H:i:s'));

        $this->deletedAt = $this->deletedAt instanceof DateTime || $this->deletedAt === null
            ? $this->deletedAt
            : new DateTime($this->deletedAt);

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
        $this->updatedAt = new DateTime;

        $this->validate();
    }

    public function delete(): void
    {
        $this->deletedAt = new DateTime;
        $this->updatedAt = $this->deletedAt;
    }

    public function validate(): void
    {
        DomainValidation::notNull($this->name);
        DomainValidation::strMaxLength($this->name);
        DomainValidation::strMinLength($this->name);
        DomainValidation::strCanNullAndMaxLength($this->description);
    }
}
