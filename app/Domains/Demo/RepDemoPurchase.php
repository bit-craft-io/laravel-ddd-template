<?php

declare(strict_types=1);

namespace App\Domains\Demo;

use App\DataSources\DsHub;
use App\Domains\EntHub;
use BitCraft\Core\Domains\Entity\BaseEnt;
use BitCraft\Core\Domains\Repository\BaseRep;
use BitCraft\Core\Libraries\Stateful\Instance\StfInsIterator;

/**
 * デモ購入履歴のリポジトリ
 *
 * デモ購入履歴の Ent を作成・保存・取得する。
 */
class RepDemoPurchase extends BaseRep
{
    /**
     * @param int $user_id
     * @return EntDemoPurchase|BaseEnt
     */
    public function makeDraft(int $user_id): EntDemoPurchase|BaseEnt
    {
        $model = $this->_DataSource::make(DsHub::DS_U_DEMO_PURCHASE)->makeDraft($user_id);

        return $this->_Domain::ent(EntHub::ENT_DEMO_PURCHASE)->init($model);
    }

    /**
     * @param EntDemoPurchase $ent
     * @return void
     */
    public function persist(EntDemoPurchase $ent): void
    {
        $ds = $this->_DataSource::make(DsHub::DS_U_DEMO_PURCHASE);
        $ent->commit();
        if ($ent->isNew()) {
            $ent->id($ds->createGetId($ent->getProperties()));
            $ent->commit();
        } else {
            $ds->update($ent->getProperties(), ['id' => $ent->id]);
        }
    }

    /**
     * @param int $user_id
     * @return StfInsIterator<EntDemoPurchase|BaseEnt>
     */
    public function getByUserId(int $user_id): StfInsIterator
    {
        $models = $this->_DataSource::make(DsHub::DS_U_DEMO_PURCHASE)->getByUserId($user_id);

        return $this->_Domain::entIterator(EntHub::ENT_DEMO_PURCHASE, $models);
    }
}
