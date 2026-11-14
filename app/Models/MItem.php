<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Enum\TypeItem;
use Illuminate\Database\Eloquent\Model;

class MItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'type_item',
        'max_display',
        'max_stock',
        'begin_at',
        'end_at',
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
        'name' => 'string',
        'type_item' => TypeItem::class,
        'max_display' => 'integer',
        'max_stock' => 'integer',
        'begin_at' => 'datetime:Y-m-d H:i:s',
        'end_at' => 'datetime:Y-m-d H:i:s',
    ];

    // @note Builder の責任を DataSource に持たせる
    //public function scopeEnable(Builder $query): Builder
    //{
    //    // TODO baseModel
    //    $now = now();
    //    return $query
    //        ->where(function ($query) use ($now) {
    //            $query->whereNull('begin_at')
    //                ->orWhere('begin_at', '<=', $now);
    //        })
    //        ->where(function ($query) use ($now) {
    //            $query->whereNull('end_at')
    //                ->orWhere('end_at', '>=', $now);
    //        });
    //}
}
