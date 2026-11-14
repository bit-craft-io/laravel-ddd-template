<?php

declare(strict_types=1);

namespace App\Domains\Gacha;

use BitCraft\Core\Domains\Entity\BaseEnt;
use BitCraft\Core\Domains\Repository\BaseRep;
use App\DataSources\DsHub;
use App\Domains\EntHub;

class RepGacha extends BaseRep
{
    /**
     * @param int $user_id
     * @return EntGacha
     */
    public function find(int $user_id): EntGacha
    {
        $model = $this->_DataSource::make(DsHub::DS_U_GACHA)->findByUserId($user_id);
        return $this->_Domain::ent(EntHub::ENT_GACHA)->init($model);
    }

    /**
     * @param $user_id
     * @return BaseEnt|string
     */
    public function makeDraft($user_id)
    {
        $model = $this->_DataSource::make(DsHub::DS_U_GACHA)->makeDraft($user_id);
        return $this->_Domain::ent(EntHub::ENT_GACHA)->init($model);
    }

    /**
     * @param EntGacha|BaseEnt $ent
     * @return void
     */
    public function persist(EntGacha|BaseEnt $ent): void
    {
        $ent->commit();
        if ($ent->isNew()) {
            $this->_DataSource::make(DsHub::DS_U_GACHA)->create($ent->getProperties());
        } else {
            $this->_DataSource::make(DsHub::DS_U_GACHA)->update($ent->getProperties(), ['user_id' => $ent->user_id]);
        }
    }
}
