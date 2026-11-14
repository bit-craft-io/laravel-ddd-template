<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * デモ購入履歴モデル
 *
 * u_demo_purchases の 1 行を表す。
 */
class UDemoPurchase extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'purchase_no',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'product_id' => 'integer',
        'quantity' => 'integer',
        'total_price' => 'integer',
        'purchase_no' => 'string',
    ];
}
