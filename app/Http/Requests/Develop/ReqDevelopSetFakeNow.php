<?php

declare(strict_types=1);

namespace App\Http\Requests\Develop;

use BitCraft\Core\Http\Requests\BaseReq;

/**
 * @property-read string $fake_now
 */
final class ReqDevelopSetFakeNow extends BaseReq
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'fake_now' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
