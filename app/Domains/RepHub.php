<?php

declare(strict_types=1);

namespace App\Domains;

use App\Domains\Demo\RepDemoPurchase;
use App\Domains\Gacha\RepGacha;
use App\Domains\Idle\RepIdle;
use App\Domains\Item\RepItem;

final class RepHub
{
    const string REP_ITEM = RepItem::class;
    const string REP_GACHA = RepGacha::class;
    const string REP_IDLE = RepIdle::class;
    const string REP_DEMO_PURCHASE = RepDemoPurchase::class;
}
