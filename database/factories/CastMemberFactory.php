<?php

namespace Database\Factories;

use App\Core\Enum\CastMemberTypeEnum;
use App\Models\CastMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CastMember>
 */
class CastMemberFactory extends Factory
{
    protected $model = CastMember::class;

    /**
     * @return array{id: string, name: string, type: int}
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'type' => $this->faker->randomElement(CastMemberTypeEnum::cases())->value,
        ];
    }
}
