<?php

declare(strict_types=1);

namespace App\Http\Applications;

use BitCraft\Core\Http\Applications\BaseApp;
use App\Domains\RepHub;
use App\Http\Requests\Idle\ReqIdleSync;
use App\Models\Enum\TypeIdle;

class AppIdle extends BaseApp
{
    public function sync(ReqIdleSync $req): void
    {
        $this->_Transaction::begin();

        $type_idle = TypeIdle::from($req->type_idle ?? 0);
        $index_no = $req->index_no ?? 0;
        $rep_idle = $this->_Domain::rep(RepHub::REP_IDLE);
        $ent_idle = $rep_idle->find($req->user_id, $type_idle->value, $index_no);
        if ($ent_idle->isEmpty()) {
            $ent_idle = $rep_idle->makeDraft($req->user_id, $type_idle->value, $index_no);
        }

        $idle_info = $ent_idle->info();
        if ($idle_info['can_recover'] ?? false) {
            $ent_idle->begin_at($this->_Date::baseNow()->toDateTimeString());
            $rep_idle->persist($ent_idle);

            if ($type_idle->isEnergy()) {
                $rep_user = $this->_Domain::rep(RepHub::REP_USER);
                $ent_user = $rep_user->findByUserId($req->user_id);
                // @note 最大値の超過のチェックは EntUser の責任
                $ent_user->addEnergy($idle_info['add_num']);
                $rep_user->persist($ent_user);
            }

            if ($type_idle->isCraft()) {
                // @note Craft の処理
            }
        }

        // TODO レスポンスの型
        $this->_ResponseParam::set('idle_info', $idle_info);
        $this->_ResponseParam::set('stash_contents', $ent_idle->stash_contents);
    }
}
