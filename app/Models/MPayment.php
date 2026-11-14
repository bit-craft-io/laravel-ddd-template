<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Enum\TypeDraw;
use Illuminate\Database\Eloquent\Model;

class MPayment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'type_store',
        'type_charge',
        'charge_amount',
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
        'type_store' => 'integer',
        'type_charge' => 'integer',
        'charge_amount' => 'integer',
    ];
}
