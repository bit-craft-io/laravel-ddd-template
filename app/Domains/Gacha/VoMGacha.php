<?php

declare(strict_types=1);

namespace App\Domains\Gacha;

use BitCraft\Core\Domains\ValueObject\BaseMstVo;
use App\Models\Enum\TypeCost;
use App\Models\Enum\TypeDraw;

/**
 * @property-read integer $id
 * @property-read string $name
 * @property-read integer $is_active
 * @property-read string $begin_at
 * @property-read string $end_at
 * @property-read TypeDraw $type_draw
 * @property-read integer $group_no
 * @property-read integer $exec_count
 * @property-read integer $exec_count_limit
 * @property-read TypeCost $type_cost
 * @property-read integer $cost_id
 * @property-read integer $total_cost_amount
 * @property-read integer $draw_count
 * @property-read integer $gacha_draw_rarity_group_no
 * @property-read integer $gacha_draw_entity_group_no
 * @property-read integer $display_order
 * @property-read string $banner_image_name
 */
class VoMGacha extends BaseMstVo
{
    /**
     * @return bool
     */
    public function validate(): bool
    {
        if ($this->gacha_draw_entity_group_no <= 0) {
            return false;
        }

        if ($this->type_draw->isRarity()) {
            if ($this->gacha_draw_rarity_group_no <= 0) {
                return false;
            }
            return true;
        }

        return true;
    }

    /**
     * @param int $u_entity_amount
     * @return bool
     */
    public function enoughCost(int $u_entity_amount): bool
    {
        return $this->total_cost_amount <= $u_entity_amount;
    }

    /**
     * @param int $exec_count
     * @return bool
     */
    public function isExecCountOver(int $exec_count): bool
    {
        if ($this->exec_count_limit === 0) {
            return false;
        }
        return $exec_count >= $this->exec_count_limit;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type_draw' => $this->type_draw,
            'group_no' => $this->group_no,
            'exec_count' => $this->exec_count,
            'type_cost' => $this->type_cost,
            'cost_id' => $this->cost_id,
            'total_cost_amount' => $this->total_cost_amount,
            'draw_count' => $this->draw_count,
            'banner_image_name' => $this->banner_image_name,
        ];
    }
}
