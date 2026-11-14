<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAccessInfo extends Model
{
    // TODO 20260609 ここをもう少し考える on('log_db')
    //protected $connection = 'log_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'public_id',
        'level',
        'api',
        'param',
        'file',
        'line',
        'option_info',
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
        'public_id' => 'string',
        'level' => 'integer',
        'api' => 'string',
        'param' => 'json',
        'file' => 'string',
        'line' => 'integer',
        'option_info' => 'json',
    ];
}
