<?php

declare(strict_types=1);

namespace App\DataSources;

final class DsHub
{

    const string DS_M_ITEM = DsMItem::class;
    const string DS_M_GACHA = DsMGacha::class;
    const string DS_M_GACHA_DRAW_ENTITY = DsMGachaDrawEntity::class;
    const string DS_M_GACHA_DRAW_RARITY = DsMGachaDrawRarity::class;
    const string DS_M_DEMO_PRODUCT = DsMDemoProduct::class;

    const string DS_U_ITEM = DsUItem::class;
    const string DS_U_GACHA = DsUGacha::class;
    const string DS_U_IDLE = DsUIdle::class;
    const string DS_U_DEMO_PURCHASE = DsUDemoPurchase::class;
}
