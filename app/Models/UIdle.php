<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Enum\TypeIdle;
use Illuminate\Database\Eloquent\Model;

class UIdle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'type_idle',
        'index_no',
        'progress_id',
        'begin_at',
        'end_at',
        'end_forward_sec',
        'stash_contents',
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
        'type_idle' => TypeIdle::class,
        'index_no' => 'integer',
        'begin_at' => 'datetime:Y-m-d H:i:s',
        'end_at' => 'datetime:Y-m-d H:i:s',
        'end_forward_sec' => 'integer',
        'stash_contents' => 'json',
    ];
}
