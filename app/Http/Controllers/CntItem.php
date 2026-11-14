<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use BitCraft\Core\Http\Controllers\BaseCnt;
use App\Http\Responses\Item\ResItemFind;
use App\Http\Responses\Item\ResItemGet;

class CntItem extends BaseCnt
{
    /**
     * @return void
     */
    public function get(): void
    {
        $this->_ResponseModify::set(ResItemGet::class);
    }

    /**
     * @return void
     */
    public function find(): void
    {
        $this->_ResponseModify::set(ResItemFind::class);
    }
}
