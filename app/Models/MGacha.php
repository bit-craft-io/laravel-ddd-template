<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Enum\TypeDraw;
use Illuminate\Database\Eloquent\Model;

class MGacha extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'is_active',
        'type_draw',
        'group_no',
        'exec_count',
        'exec_count_limit',
        'item_id',
        'total_cost',
        'draw_count',
        'gacha_draw_rarity_group_no',
        'gacha_draw_entity_group_no',
        'begin_at',
        'end_at',
        'display_order',
        'banner_image_name',
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
        'name' => 'string',
        'is_active' => 'boolean',
        'type_draw' => TypeDraw::class,
        'group_no' => 'integer',
        'exec_count' => 'integer',
        'exec_count_limit' => 'integer',
        'item_id' => 'integer',
        'total_cost' => 'integer',
        'draw_count' => 'integer',
        'gacha_draw_rarity_group_no' => 'integer',
        'gacha_draw_entity_group_no' => 'integer',
        'begin_at' => 'datetime:Y-m-d H:i:s',
        'end_at' => 'datetime:Y-m-d H:i:s',
        'display_order' => 'integer',
        'banner_image_name' => 'string',
    ];
}
