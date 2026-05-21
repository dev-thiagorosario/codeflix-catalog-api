<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity;

use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Domain\Trait\MethodsMagicsTraits;
use App\Core\Domain\Validation\DomainValidation;
use App\Models\Category;
use App\Models\Genre;
use DateTime;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/**
 * @property-read string $name
 * @property-read bool $isActive
 * @property-read DateTime $createdAt
 * @property-read DateTime $updatedAt
 * @property-read DateTime|null $deletedAt
 * @property-read array<int, string> $categoriesId
 */
class GenreEntity
{
    use MethodsMagicsTraits;

    /**
     * @param  array<int, string>  $categoriesId
     */
    public function __construct(
        protected UuidResolver|string|null $id = null,
        protected string $name = '',
        protected bool $isActive = true,
        protected array $categoriesId = [],
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

        $this->categoriesId = array_values(array_unique($this->categoriesId));

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
        if (in_array($categoryId, $this->categoriesId, true)) {
            return;
        }

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

    public static function fromModel(Genre $model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
            isActive: (bool) $model->is_active,
            categoriesId: self::categoriesIdFromModel($model),
            createdAt: $model->created_at?->format('Y-m-d H:i:s'),
            updatedAt: $model->updated_at?->format('Y-m-d H:i:s'),
            deletedAt: $model->deleted_at?->format('Y-m-d H:i:s'),
        );
    }

    /**
     * @return array<int, string>
     */
    private static function categoriesIdFromModel(Genre $model): array
    {
        if (! $model->relationLoaded('categories')) {
            return [];
        }

        /** @var EloquentCollection<int, Category> $categories */
        $categories = $model->getRelation('categories');

        return $categories->pluck('id')->all();
    }
}
