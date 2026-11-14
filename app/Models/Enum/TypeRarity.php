<?php

declare(strict_types=1);

namespace App\Models\Enum;

enum TypeRarity: int
{
    case Normal = 1;
    case Rare = 2;
    case SuperRare = 3;
    case UltraRare = 4;
    case LegendRare = 5;

    public function label(): string
    {
        return match ($this) {
            self::Normal => 'ノーマル',
            self::Rare => 'レア',
            self::SuperRare => 'スーパーレア',
            self::UltraRare => 'ウルトラレア',
            self::LegendRare => 'レジェンドレア',
        };
    }

    public function isNormal(): bool
    {
        return $this === self::Normal;
    }

    public function isRare(): bool
    {
        return $this === self::Rare;
    }

    public function isSuperRare(): bool
    {
        return $this === self::SuperRare;
    }

    public function isLegendRare(): bool
    {
        return $this === self::LegendRare;
    }
}
