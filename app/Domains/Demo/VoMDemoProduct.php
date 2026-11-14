<?php

declare(strict_types=1);

namespace App\Domains\Demo;

use BitCraft\Core\Domains\ValueObject\BaseMstVo;

/**
 * デモ商品マスタの値オブジェクト
 *
 * 公開中のデモ商品を、読み取り専用で表す。
 *
 * @property-read int $id
 * @property-read string $name
 * @property-read bool $is_active
 * @property-read \Carbon\CarbonInterface|null $begin_at
 * @property-read \Carbon\CarbonInterface|null $end_at
 * @property-read int $price
 * @property-read int $purchase_limit
 * @property-read int $display_order
 */
class VoMDemoProduct extends BaseMstVo
{
}
