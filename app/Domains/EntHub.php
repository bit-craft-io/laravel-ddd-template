<?php

declare(strict_types=1);

namespace App\Domains;

use App\Domains\Demo\EntDemoPurchase;
use App\Domains\Gacha\EntGacha;
use App\Domains\Idle\EntIdle;
use App\Domains\Item\EntItem;

final class EntHub
{
    const string ENT_ITEM = EntItem::class;
    const string ENT_GACHA = EntGacha::class;
    const string ENT_IDLE = EntIdle::class;
    const string ENT_DEMO_PURCHASE = EntDemoPurchase::class;
}
