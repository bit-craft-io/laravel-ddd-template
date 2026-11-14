<?php

declare(strict_types=1);

namespace App\Http\Requests\Gacha;

use BitCraft\Core\Http\Requests\BaseReq;

/**
 * @property-read integer $gacha_id
 */
final class ReqGachaPlay extends BaseReq
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'gacha_id' => 'required|integer',
        ];
    }
}
