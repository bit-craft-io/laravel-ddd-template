<?php

declare(strict_types=1);

namespace App\Domains\Idle;

use BitCraft\Core\Domains\Entity\BaseEnt;
use BitCraft\Core\Domains\Repository\BaseRep;
use BitCraft\Core\DataSources\DsHub as CoreDsHub;
use App\DataSources\DsHub;
use App\Domains\EntHub;

class RepIdle extends BaseRep
{
    /**
     * @param int $user_id
     * @param int $type_idle
     * @param int $index_no
     * @return EntIdle
     */
    public function find(int $user_id, int $type_idle, int $index_no): EntIdle
    {
        $model = $this->_DataSource::make(DsHub::DS_U_IDLE)->findByUnique($user_id, $type_idle, $index_no);
        return $this->_Domain::ent(EntHub::ENT_IDLE)->init($model);
    }

    /**
     * @param int $user_id
     * @param int $type_idle
     * @param int $index_no
     * @return EntIdle
     */
    public function makeDraft(int $user_id, int $type_idle, int $index_no): EntIdle
    {
        $u_user = $this->_DataSource::make(CoreDsHub::DS_U_USER)->findByUserId($user_id);
        $model = $this->_DataSource::make(DsHub::DS_U_IDLE)->makeDraft([
            'user_id' => $user_id,
            'type_idle' => $type_idle,
            'index_no' => $index_no,
            'begin_at' => $u_user->created_at->toDateTimeString()
        ]);
        return $this->_Domain::ent(EntHub::ENT_IDLE)->init($model);
    }

    /**
     * @param EntIdle|BaseEnt $ent
     * @return void
     */
    public function persist(EntIdle|BaseEnt $ent): void
    {
        $ent->commit();
        if ($ent->isNew()) {
            $this->_DataSource::make(DsHub::DS_U_IDLE)->create($ent->getProperties());
        } else {
            $this->_DataSource::make(DsHub::DS_U_IDLE)->update($ent->getProperties(), [
                'user_id' => $ent->user_id,
                'type_idle' => $ent->type_idle->value,
                'index_no' => $ent->index_no,
            ]);
        }
    }
}
