<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Enum\CastMemberTypeEnum;
use Database\Factories\CastMemberFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CastMember extends Model
{
    /** @use HasFactory<CastMemberFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'cast_members';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'type',
    ];

    protected $casts = [
        'id' => 'string',
        'type' => CastMemberTypeEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
