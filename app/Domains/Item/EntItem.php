<?php

declare(strict_types=1);

namespace App\Domains\Item;

use BitCraft\Core\Domains\Entity\BaseEnt;
use BitCraft\Core\Domains\ValueProxy\VpItem;

/**
 * @method void user_id(integer $value)
 * @method void item_id(integer $value)
 * @method void amount(integer $value)
 * @method void end_at(string $value)
 * @property-read integer $user_id
 * @property-read integer $item_id
 * @property-read integer $amount
 * @property-read object $end_at
 */
class EntItem extends BaseEnt
{
    //protected bool $_auto_commit = true;
    protected VpItem $_vp_item;

    /**
     * @return void
     */
    public function initOnce(): void
    {
        // TODO: Implement setUp() method.
    }

    /**
     * @return void
     */
    public function initAfter(): void
    {
        $this->_vp_item = $this->_Domain::vp(VpHub::VP_ITEM)->init($this);
    }

    //public function addAmount(int $amount): void
    //{
    //    // @note 責任を分離した場合の処理
    //    //       max_stock は m_items の値の為 $vo_m_items に問い合わせ
    //    // $vo_m_items = $this->_vo_m_items?->find($this->item_id);
    //    // $sum_amount = $vo_m_items->minAmount($this->amount + $amount);
    //    // $this->_vp_item->add($sum_amount);
    //
    //    //$m_item = $this->_m_item_map[$this->item_id];
    //    //$sum_amount = min($m_item['max_stock'], $this->amount + $amount);
    //    $this->_vp_item->amount($amount);
    //}

    /**
     * @param int $amount
     * @return void
     */
    public function subAmount(int $amount): void
    {
        $this->_vp_item->sub($amount);
    }

    /**
     * @param int $amount
     * @return bool
     */
    public function hasAmount(int $amount): bool
    {
        return $this->_vp_item->has($amount);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'item_id' => $this->item_id,
            'amount' => $this->amount,
            'end_at' => $this->end_at?->toDateTimeString() ?? '',
        ];
    }
}
