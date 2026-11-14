<?php

declare(strict_types=1);

namespace App\Models\Enum;

enum TypeIdle: int
{
    case Energy = 1;
    case Craft = 2;

    public function label(): string
    {
        return match ($this) {
            self::Energy => 'エナジー',
            self::Craft => '製造',
        };
    }

    public function isEnergy(): bool
    {
        return $this === self::Energy;
    }

    public function isCraft(): bool
    {
        return $this === self::Craft;
    }
}
