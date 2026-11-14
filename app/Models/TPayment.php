<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Enum\TypeDraw;
use Illuminate\Database\Eloquent\Model;

class TPayment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'transaction_id',
        'user_id',
        'type_store',
        'type_currency',
        'type_progress',
        'purchased_item_id',
        'purchased_amount',
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
        'user_id' => 'integer',
        'type_store' => 'integer',
        'type_currency' => 'integer',
        'type_progress' => 'integer',
        'purchased_item_id' => 'integer',
        'purchased_amount' => 'integer',
    ];
}
