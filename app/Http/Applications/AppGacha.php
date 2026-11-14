<?php

declare(strict_types=1);

namespace App\Http\Applications;

use BitCraft\Core\Http\Applications\BaseApp;
use BitCraft\Core\Http\Requests\ReqNone;
use App\Domains\Gacha\VoHub;
use App\Domains\RepHub;
use App\Exceptions\Enum\TypeExceptGacha;
use App\Http\Requests\Gacha\ReqGachaPlay;
use App\Http\Services\SvcHub;
use Exception;

class AppGacha extends BaseApp
{
    /**
     * @param ReqGachaPlay $req
     * @return void
     * @throws Exception
     */
    public function play(ReqGachaPlay $req): void
    {
        // @note このやり方はイマイチ
        //$m_gachas = $this->_App::mst(MstHub::MST_GACHA)->get();
        //$m_gacha = $m_gachas->find($req->gacha_id);
        //if (!$m_gacha->validate()) {
        //    throw $this->_Except::app(TypeExcept::ModelDataNotFound);
        //}
        //
        //$rep_gacha = $this->_Domain::rep(RepHub::REP_GACHA);
        //$ent_gacha = $rep_gacha->find($req->user_id);
        //
        //$result_lots = $this->_Domain::svc(SvcHub::SVC_GACHA)->draw($m_gacha);

        // @note トランザクション処理をする場合
        $this->_Transaction::begin();

        $vo_gacha = $this->_Domain::mstVo(VoHub::VO_M_GACHA)->findOrFail($req->gacha_id);
        if (!$vo_gacha->validate()) {
            $except_params['#1'] = $vo_gacha->id;
            throw $this->_Except::app(TypeExceptGacha::AppGachaMasterIsNotValid, $except_params);
        }

        // @note コストが足りるか確認
        $rep_item = $this->_Domain::rep(RepHub::REP_ITEM);
        $ent_item = $rep_item->find($req->user_id, $vo_gacha->cost_id);
        if ($ent_item->isEmpty()) {
            throw $this->_Except::app(TypeExceptGacha::AppGachaItemIsEmpty);
        }
        if (!$vo_gacha->enoughCost($ent_item->amount)) {
            throw $this->_Except::app(TypeExceptGacha::AppGachaCostIsNotEnough);
        }
        $ent_item->subAmount($vo_gacha->total_cost_amount);

        // @note ガチャ実行サービス内で処理
        $svc_gacha = $this->_Domain::svc(SvcHub::SVC_GACHA);
        $result_svc_gacha_draw = $svc_gacha->draw($req->user_id, $req->gacha_id);
        $this->_ResponseParam::set('gacha_draws', $result_svc_gacha_draw);

        // @note $svc_gacha の戻り値 $result_svc_gacha_draw より present_box の処理
        //       処理は割愛します

        // @note 各ドメインを永続化
        $rep_item->persist($ent_item);
        //$rep_present_box->persist($ent_present_box);

        // @note 計算結果を反映後の数値（$ent_item->commit()）を取得
        $this->_ResponseParam::set('item_info', $ent_item->toArray());
    }
}
