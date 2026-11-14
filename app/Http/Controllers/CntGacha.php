<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use BitCraft\Core\Http\Controllers\BaseCnt;
use App\Http\Applications\AppGacha;
use App\Http\Requests\Gacha\ReqGachaPlay;
use App\Http\Responses\Gacha\ResGachaGet;
use Exception;

class CntGacha extends BaseCnt
{
    /**
     * @return void
     */
    public function get(): void
    {
        $this->_ResponseModify::set(ResGachaGet::class);
    }

    /**
     * @param AppGacha $app
     * @param ReqGachaPlay $req
     * @return void
     * @throws Exception
     */
    public function play(AppGacha $app, ReqGachaPlay $req): void
    {
        $app->play($req);
    }
}
