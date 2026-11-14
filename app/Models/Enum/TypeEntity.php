<?php

declare(strict_types=1);

namespace App\Models\Enum;

enum TypeEntity: int
{
    case Item = 1;
    case Playable = 2;

    public function label(): string
    {
        return match ($this) {
            self::Item => 'アイテム',
            self::Playable => 'プレイアブル',
        };
    }

    public function isItem(): bool
    {
        return $this === self::Item;
    }

    public function isPlayable(): bool
    {
        return $this === self::Playable;
    }
}
