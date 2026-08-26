<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity;

use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Domain\Trait\MethodsMagicsTraits;
use App\Core\Domain\Validation\DomainValidation;
use App\Core\Enum\CastMemberTypeEnum;
use App\Models\CastMember;
use DateTime;

/**
 * @property-read string $name
 * @property-read CastMemberTypeEnum $type
 * @property-read DateTime $createdAt
 */
class CastMemberEntity
{
    use MethodsMagicsTraits;

    public function __construct(
        protected string $name,
        protected CastMemberTypeEnum $type,
        protected UuidResolver|string|null $id = null,
        protected DateTime|string|null $createdAt = null,
    ) {
        $this->id = match (true) {
            $this->id instanceof UuidResolver => $this->id,
            is_string($this->id) => new UuidResolver($this->id),
            default => UuidResolver::random(),
        };

        $this->createdAt = $this->createdAt instanceof DateTime
            ? $this->createdAt
            : new DateTime($this->createdAt ?: 'now');

        $this->validateName($this->name);
    }

    public function update(string $name, CastMemberTypeEnum $type): void
    {
        $this->validateName($name);

        $this->name = $name;
        $this->type = $type;
    }

    protected function validateName(string $name): void
    {
        DomainValidation::notNull($name);
        DomainValidation::strMaxLength($name);
        DomainValidation::strMinLength($name);
    }

    public static function fromModel(CastMember $model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
            type: $model->type,
            createdAt: $model->created_at?->format('Y-m-d H:i:s'),
        );
    }
}
