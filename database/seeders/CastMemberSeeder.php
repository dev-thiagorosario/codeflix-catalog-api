<?php

namespace Database\Seeders;

use App\Core\Enum\CastMemberTypeEnum;
use App\Models\CastMember;
use Illuminate\Database\Seeder;

class CastMemberSeeder extends Seeder
{
    public function run(): void
    {
        CastMember::factory()->create([
            'name' => 'John Doe',
            'type' => CastMemberTypeEnum::DIRECTOR,
        ]);

        CastMember::factory(9)->create();
    }
}
