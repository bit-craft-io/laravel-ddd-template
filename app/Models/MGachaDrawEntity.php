<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Enum\TypeEntity;
use App\Models\Enum\TypeRarity;
use Illuminate\Database\Eloquent\Model;

class MGachaDrawEntity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'group_no',
        'type_rarity',
        'type_entity',
        'entity_id',
        'entity_amount',
        'rate',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'is_active',
        'begin_at',
        'end_at',
        'ops_memo',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'group_no' => 'integer',
        'type_rarity' => TypeRarity::class,
        'type_entity' => TypeEntity::class,
        'entity_id' => 'integer',
        'entity_amount' => 'integer',
        'rate' => 'integer',
        'ops_memo' => 'string',
    ];
}
