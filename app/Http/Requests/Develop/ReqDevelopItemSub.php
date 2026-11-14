<?php

declare(strict_types=1);

namespace App\Http\Requests\Develop;

use BitCraft\Core\Http\Requests\BaseReq;

/**
 * @property-read integer $item_id
 * @property-read integer $amount
 */
final class ReqDevelopItemSub extends BaseReq
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'item_id' => 'required|integer',
            'amount' => 'required|integer',
        ];
    }
}
