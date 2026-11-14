<?php

declare(strict_types=1);

namespace App\Models\Enum;

enum TypeDraw: int
{
    case Normal = 1;
    case Step = 2;
    case Fixed = 3;
    case Rarity = 4;

    public function label(): string
    {
        return match ($this) {
            self::Normal => '通常抽選',
            self::Step => 'ステップアップ抽選',
            self::Fixed => '枠確定抽選',
            self::Rarity => 'レアリティ抽選',
        };
    }

    public function isNormal(): bool
    {
        return $this === self::Normal;
    }

    public function isStep(): bool
    {
        return $this === self::Step;
    }

    public function isFixed(): bool
    {
        return $this === self::Fixed;
    }

    public function isRarity(): bool
    {
        return $this === self::Rarity;
    }
}
