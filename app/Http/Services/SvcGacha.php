<?php

declare(strict_types=1);

namespace App\Http\Services;

use BitCraft\Core\Libraries\Traits\TraitDomain;
use BitCraft\Core\Libraries\Traits\TraitInfra;
use BitCraft\Core\Libraries\Traits\TraitCore;
use BitCraft\Core\Libraries\Traits\TraitDevelop;
use BitCraft\Core\Libraries\Traits\TraitUtil;
use App\Domains\Gacha\EntGacha;
use App\Domains\Gacha\VoMGacha;
use App\Domains\Gacha\VoHub;
use App\Domains\RepHub;
use App\Exceptions\Enum\TypeExceptGacha;
use App\Models\Enum\TypeDraw;
use Exception;

// TODO extends BaseSvc
class SvcGacha //extends BaseSvc
{
    use TraitCore;
    use TraitUtil;
    use TraitInfra;
    use TraitDomain;

    /**
     * @throws Exception
     */
    public function draw(int $user_id, int $gacha_id): array
    {
        $rep_gacha = $this->_Domain::rep(RepHub::REP_GACHA);
        $ent_gacha = $rep_gacha->find($user_id);
        if ($ent_gacha->isEmpty()) {
            $ent_gacha = $rep_gacha->makeDraft($user_id);
        }

        $vo_gacha = $this->_Domain::mstVo(VoHub::VO_M_GACHA)->findOrFail($gacha_id);
        $exec_count = $ent_gacha->getExecCount($vo_gacha->group_no);
        if ($vo_gacha->isExecCountOver($exec_count)) {
            $except_params['#1'] = $vo_gacha->group_no;
            throw $this->_Except::app(TypeExceptGacha::AppGachaExecCountOver, $except_params);
        }

        $draw_lots = match (true) {
            $vo_gacha->type_draw->isNormal() => $this->_normal($vo_gacha, $ent_gacha),
            $vo_gacha->type_draw->isRarity() => $this->_rarity($vo_gacha, $ent_gacha),
            $vo_gacha->type_draw->isFixed() => $this->_fixed($vo_gacha, $ent_gacha),
            $vo_gacha->type_draw->isStep() => $this->_step($vo_gacha, $ent_gacha),
        };

        $ent_gacha->addExecCount($vo_gacha->group_no);
        $rep_gacha->persist($ent_gacha);

        return $draw_lots;
    }

    private function _normal(VoMGacha $vo_gacha, EntGacha $ent_gacha): array
    {
        // @note _Infra を使用しない方法に変更

        // @note エンティティ抽選用のデータ取得
        //$conditions = ['group_no' => $vo_gacha->gacha_draw_entity_group_no];
        //$m_gacha_draw_entities = $this->_DataSource::make(DsHub::DS_M_GACHA_DRAW_ENTITY)->getEnable($conditions);
        //$sorted_rates = $m_gacha_draw_entities->sortByDesc('rate')->values()->toArray();

        // @note エンティティ抽選用のデータ取得
        $conditions = ['group_no' => $vo_gacha->gacha_draw_entity_group_no];
        $vo_gacha_draw_entities = $this->_Domain::mstVo(VoHub::VO_M_GACHA_DRAW_ENTITY)->get($conditions);

        // @note エンティティ抽選用のデータ作成
        $sorted_rates = $vo_gacha_draw_entities->collect()->sortByDesc('rate')->values()->toArray();
        $cum_rates = $this->_cumulativeRate($sorted_rates);

        $draw_lots = [];
        for ($i = 0; $i < $vo_gacha->draw_count; $i++) {
            // @note エンティティ抽選
            $draw_lots[] = $this->_drawLot($sorted_rates, $cum_rates, ['type_entity', 'entity_id', 'entity_amount']);
        }
        return $draw_lots;
    }

    private function _fixed(VoMGacha $vo_gacha, EntGacha $ent_gacha): array
    {
        // TODO dummy
        return $this->_normal($vo_gacha, $ent_gacha);
    }

    private function _rarity(VoMGacha $vo_gacha, EntGacha $ent_gacha): array
    {
        // @note _Infra を使用しない方法に変更

        // @note レアリティ抽選用のデータ取得
        //$conditions = ['group_no' => $vo_gacha->gacha_draw_rarity_group_no];
        //$m_gacha_draw_rarities = $this->_DataSource::make(DsHub::DS_M_GACHA_DRAW_RARITY)->getEnable($conditions);

        // @note レアリティ抽選用のデータ作成
        //$rarity_sorted_rates = $m_gacha_draw_rarities->sortByDesc('rate')->values()->toArray();
        //$rarity_cum_rates = $this->_cumulativeRate($rarity_sorted_rates);

        // @note レアリティ抽選用のデータ取得
        $conditions = ['group_no' => $vo_gacha->gacha_draw_rarity_group_no];
        $vo_gacha_draw_rarities = $this->_Domain::mstVo(VoHub::VO_M_GACHA_DRAW_RARITY)->get($conditions);

        // @note レアリティ抽選用のデータ作成
        $rarity_sorted_rates = $vo_gacha_draw_rarities->collect()->sortByDesc('rate')->values()->toArray();
        $rarity_cum_rates = $this->_cumulativeRate($rarity_sorted_rates);

        // @note エンティティ抽選用のデータ取得
        //$conditions = ['group_no' => $vo_gacha->gacha_draw_entity_group_no];
        //$m_gacha_draw_entities = $this->_DataSource::make(DsHub::DS_M_GACHA_DRAW_ENTITY)->getEnable($conditions);
        // @note エンティティ抽選用のデータ取得
        $conditions = ['group_no' => $vo_gacha->gacha_draw_entity_group_no];
        $vo_gacha_draw_entities = $this->_Domain::mstVo(VoHub::VO_M_GACHA_DRAW_ENTITY)->get($conditions);

        $entities = [];
        $draw_lots = [];
        for ($i = 0; $i < $vo_gacha->draw_count; $i++) {

            // @note レアリティ抽選
            $lot_results = $this->_drawLot($rarity_sorted_rates, $rarity_cum_rates, ['type_rarity']);
            $type_rarity = $lot_results['type_rarity'];

            // @note エンティティ抽選用のデータ作成
            if (empty($entities[$type_rarity])) {
                //$entities[$type_rarity] = $m_gacha_draw_entities->filter(fn($entity): bool => $entity->type_rarity->value == $type_rarity);
                $entities[$type_rarity] = $vo_gacha_draw_entities->collect()
                    ->filter(fn($entity): bool => $entity->type_rarity->value == $type_rarity);
            }

            $sorted_rates = $entities[$type_rarity]->sortByDesc('rate')->values()->toArray();
            $cum_rates = $this->_cumulativeRate($sorted_rates);

            // @note エンティティ抽選
            $draw_lots[] = $this->_drawLot($sorted_rates, $cum_rates, ['type_entity', 'entity_id', 'entity_amount']);
        }
        return $draw_lots;
    }

    private function _step(VoMGacha $vo_gacha, EntGacha $ent_gacha): array
    {
        // @note _Infra を使用しない方法に変更

        // @note 実行回数 $vo_gacha->exec_count でユーザのステップの状態を管理
        //$conditions = ['group_no' => $vo_gacha->group_no];
        //$m_gachas = $this->_DataSource::make(DsHub::DS_M_GACHA)->getEnable($conditions);
        //$exec_count_max = $m_gachas->max('exec_count');

        $conditions = ['group_no' => $vo_gacha->group_no];
        $vo_gachas = $this->_Domain::mstVo(VoHub::VO_M_GACHA)->get($conditions);
        $exec_count_max = $vo_gachas->collect()->max('exec_count');

        $step_max = $exec_count_max + 1;
        $u_step = ($ent_gacha->getExecCount($vo_gacha->group_no) % $step_max) + 1;
        $m_step = $vo_gacha->exec_count + 1;

        // @note ステップの確認
        if ($m_step !== $u_step) {
            $except_params['#1'] = $m_step;
            $except_params['#2'] = $u_step;
            throw $this->_Except::app(TypeExceptGacha::AppGachaStepNotEqual, $except_params);
        }

        return $this->_normal($vo_gacha, $ent_gacha);
    }

    private function _cumulativeRate(array $sorted_rates): array
    {
        $cum_rate = 0;
        $cum_rates = [];
        foreach ($sorted_rates as $sorted_rate) {
            $cum_rate += $sorted_rate['rate'];
            $cum_rates[] = $cum_rate;
        }
        return $cum_rates;
    }

    private function _drawLot(array $sorted_rates, array $cum_rates, array $lot_filter = []): array
    {
        $sum_rate = end($cum_rates);
        reset($cum_rates);

        $lot_num = mt_rand(1, $sum_rate);

        $left = 0;
        $right = count($cum_rates) - 1;
        $lot_filter_key = array_flip($lot_filter);

        $limit = (int)ceil(log(count($cum_rates) ?: 1, 2)) + 1;

        //while ($left <= $right) {
        for ($i = 0; $i < $limit; $i++) {
//            if ($left > $right) {
//                break;
//            }
            $mid = intdiv($left + $right, 2);
            if ($lot_num <= $cum_rates[$mid]) {
                if ($mid === 0 || $lot_num > $cum_rates[$mid - 1]) {
                    $lottery = $sorted_rates[$mid];
                    return array_intersect_key($lottery, $lot_filter_key);
                }
                $right = $mid - 1;
            } else {
                $left = $mid + 1;
            }
        }

        $this->_Log::warning('_drawLot failed');
        return array_intersect_key($sorted_rates[0], $lot_filter_key);
    }
}
