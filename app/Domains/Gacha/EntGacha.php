<?php

declare(strict_types=1);

namespace App\Domains\Gacha;

use BitCraft\Core\Domains\Entity\BaseEnt;

/**
 * @method void id(integer $value)
 * @method void user_id(integer $value)
 * @method void gacha_info(array $values)
 * @property-read integer $id
 * @property-read integer $user_id
 * @property-read array $gacha_info
 */
class EntGacha extends BaseEnt
{
    protected ?VpGachaInfo $_vp_gacha_info = null;

    //protected int $_exec_count = 0;
    //protected string $_exec_at = '';

    /**
     * @return void
     */
    public function initOnce(): void
    {
        // TODO: Implement initAfter() method.
    }

    /**
     * @return void
     */
    public function initAfter(): void
    {
        //$this->_vp_gacha_info = $this->_Domain::vp(VpHub::VP_GACHA_INFO)->init([
        //    '_exec_count' => &$this->_exec_count,
        //    '_exec_at' => &$this->_exec_at
        //]);
        $this->_vp_gacha_info = $this->_Domain::vp(VpHub::VP_GACHA_INFO)->init($this);
    }

    /**
     * @param int $group_no
     * @return void
     */
    public function addExecCount(int $group_no): void
    {
        //$info = $this->gacha_info ?? [];
        //if ($info[$group_no] ?? false) {
        //    $this->_exec_count = $info[$group_no]['_exec_count'];
        //    $this->_exec_at = $info[$group_no]['_exec_at'];
        //}

        //$info[$group_no] = $this->_vp_gacha_info->toArray();
        //$this->gacha_info($info);

        // @note vp_gacha_info で安全にJsonを操作
        //       gacha_infoのデータの使用は処理のみで完結
        //       設定されてる値を直接変更する事や分析に用いる事はしない
        $this->_vp_gacha_info->addExecCount($group_no);
    }

    /**
     * @param int $group_no
     * @return int
     */
    public function getExecCount(int $group_no): int
    {
        return $this->_vp_gacha_info?->getExecCount($group_no) ?? 0;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'gacha_info' => $this->gacha_info
        ];
    }
}
