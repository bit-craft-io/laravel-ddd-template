<?php

declare(strict_types=1);

namespace App\Http\Requests\Item;

use BitCraft\Core\Http\Requests\BaseReq;

/**
 * @property-read integer $item_id
 */
final class ReqItemFind extends BaseReq
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'item_id' => 'required|integer',
        ];
    }
}
