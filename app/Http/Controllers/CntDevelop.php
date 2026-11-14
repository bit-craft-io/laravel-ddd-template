<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use BitCraft\Core\Http\Controllers\BaseCnt;
use BitCraft\Core\Http\Requests\ReqNone;
use BitCraft\Core\Http\Responses\ResSuccess;
use App\Http\Applications\AppDevelop;
use App\Http\Requests\Develop\ReqDevelopItemAdd;
use App\Http\Requests\Develop\ReqDevelopItemSub;
use App\Http\Requests\Develop\ReqDevelopSetFakeNow;
use Exception;

class CntDevelop extends BaseCnt
{
    /**
     * @param AppDevelop $app
     * @param ReqDevelopItemAdd $req
     * @return void
     * @throws Exception
     */
    public function itemAdd(AppDevelop $app, ReqDevelopItemAdd $req): void
    {
        $this->_ResponseModify::set(ResSuccess::class);
        $app->itemAdd($req);
    }

    /**
     * @param AppDevelop $app
     * @param ReqDevelopItemSub $req
     * @return void
     * @throws Exception
     */
    public function itemSub(AppDevelop $app, ReqDevelopItemSub $req): void
    {
        $this->_ResponseModify::set(ResSuccess::class);
        $app->itemSub($req);
    }

    /**
     * @param AppDevelop $app
     * @param ReqDevelopSetFakeNow $req
     * @return void
     */
    public function setFakeNow(AppDevelop $app, ReqDevelopSetFakeNow $req)
    {
        $this->_ResponseModify::set(ResSuccess::class);
        $app->setFakeNow($req);
    }

    /**
     * @param AppDevelop $app
     * @param ReqNone $req
     * @return void
     */
    public function unsetFakeNow(AppDevelop $app, ReqNone $req)
    {
        $this->_ResponseModify::set(ResSuccess::class);
        $app->unsetFakeNow($req);
    }

    /**
     * @param AppDevelop $app
     * @return void
     */
    public function getFakeNow(AppDevelop $app)
    {
        $this->_ResponseModify::set(ResSuccess::class);
        $app->getFakeNow();
    }
}
