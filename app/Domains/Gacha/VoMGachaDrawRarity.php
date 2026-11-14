<?php

declare(strict_types=1);

namespace App\Domains\Gacha;

use BitCraft\Core\Domains\ValueObject\BaseMstVo;
use App\Models\Enum\TypeRarity;

/**
 * @property-read integer $id
 * @property-read integer $group_no
 * @property-read TypeRarity $type_rarity
 * @property-read integer $rate
 */
class VoMGachaDrawRarity extends BaseMstVo
{

}
