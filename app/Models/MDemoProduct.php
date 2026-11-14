<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * デモ商品マスタモデル
 *
 * m_demo_products の 1 行を表す。
 */
class MDemoProduct extends Model
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
        'begin_at',
        'end_at',
        'price',
        'purchase_limit',
        'display_order',
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
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'is_active' => 'boolean',
        'begin_at' => 'datetime:Y-m-d H:i:s',
        'end_at' => 'datetime:Y-m-d H:i:s',
        'price' => 'integer',
        'purchase_limit' => 'integer',
        'display_order' => 'integer',
    ];
}
