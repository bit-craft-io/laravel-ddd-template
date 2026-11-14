<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Enum\TypeRarity;
use Illuminate\Database\Eloquent\Model;

class MGachaDrawRarity extends Model
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
        'rate' => 'integer',
        'ops_memo' => 'string',
    ];
}
