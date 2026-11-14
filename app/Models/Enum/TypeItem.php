<?php

declare(strict_types=1);

namespace App\Models\Enum;

enum TypeItem: int
{
    case Consumable = 1;
    case Permanent  = 2;
    case Equipment  = 3;
    case Material   = 4;
    public function label(): string
    {
        return match($this) {
            self::Consumable => '消耗アイテム',
            self::Permanent  => '永続アイテム',
            self::Equipment  => '装備アイテム',
            self::Material   => '素材アイテム',
        };
    }

    public function isConsumable(): bool
    {
        return $this === self::Consumable;
    }

    public function isPermanent(): bool
    {
        return $this === self::Permanent;
    }

    public function isEquipment(): bool
    {
        return $this === self::Equipment;
    }

    public function isMaterial(): bool
    {
        return $this === self::Material;
    }
}
