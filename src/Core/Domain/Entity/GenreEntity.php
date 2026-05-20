<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity;

use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Domain\Trait\MethodsMagicsTraits;
use App\Core\Domain\Validation\DomainValidation;
use DateTime;

/**
 * @property-read string $name
 * @property-read bool $isActive
 * @property-read DateTime $createdAt
 * @property-read DateTime $updatedAt
 * @property-read array<int, string> $categoriesId
 */
class GenreEntity
{
    use MethodsMagicsTraits;

    /**
     * @var array<int, string>
     */
    protected array $categoriesId = [];

    public function __construct(
        protected ?UuidResolver $id = null,
        protected string $name = '',
        protected bool $isActive = true,
        protected ?DateTime $createdAt = null,
        protected ?DateTime $updatedAt = null,
    ) {
        $this->id ??= UuidResolver::random();
        $this->createdAt ??= new DateTime;
        $this->updatedAt ??= new DateTime($this->createdAt->format('Y-m-d H:i:s'));

        $this->validate();
    }

    public function activate(): void
    {
        $this->isActive = true;
    }

    public function deactivate(): void
    {
        $this->isActive = false;
    }

    public function update(string $name): void
    {
        $this->name = $name;
        $this->updatedAt = new DateTime;

        $this->validate();
    }

    public function addCategory(string $categoryId): void
    {
        $this->categoriesId[] = $categoryId;
    }

    public function removeCategory(string $categoryId): void
    {
        $key = array_search($categoryId, $this->categoriesId, true);

        if ($key === false) {
            return;
        }

        unset($this->categoriesId[$key]);

        $this->categoriesId = array_values($this->categoriesId);
    }

    protected function validate(): void
    {
        DomainValidation::notNull($this->name);
        DomainValidation::strMaxLength($this->name, 255);
        DomainValidation::strMinLength($this->name, 3);
    }
}
