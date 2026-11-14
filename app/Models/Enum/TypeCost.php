<?php

declare(strict_types=1);

namespace App\Models\Enum;

enum TypeCost: int
{
    case Item = 1;
    case Other = 2;

    public function label(): string
    {
        return match ($this) {
            self::Item => 'アイテム',
            self::Other => 'その他',
        };
    }

    public function isItem(): bool
    {
        return $this === self::Item;
    }

    public function isOther(): bool
    {
        return $this === self::Other;
    }
}
