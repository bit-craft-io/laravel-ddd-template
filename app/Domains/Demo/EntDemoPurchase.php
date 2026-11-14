<?php

declare(strict_types=1);

namespace App\Domains\Demo;

use BitCraft\Core\Domains\Entity\BaseEnt;

/**
 * デモ購入履歴のエンティティ
 *
 * ユーザの購入 1 件を表す。
 *
 * @method void id(int $value)
 * @method void user_id(int $value)
 * @method void product_id(int $value)
 * @method void quantity(int $value)
 * @method void total_price(int $value)
 * @method void purchase_no(string $value)
 * @property-read int $id
 * @property-read int $user_id
 * @property-read int $product_id
 * @property-read int $quantity
 * @property-read int $total_price
 * @property-read string $purchase_no
 */
class EntDemoPurchase extends BaseEnt
{
    /**
     * @return void
     */
    public function initOnce(): void
    {
    }

    /**
     * @return void
     */
    public function initAfter(): void
    {
    }
}
