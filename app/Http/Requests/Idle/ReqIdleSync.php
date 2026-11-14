<?php

declare(strict_types=1);

namespace App\Http\Requests\Idle;

use BitCraft\Core\Http\Requests\BaseReq;
use App\Models\Enum\TypeIdle;
use Illuminate\Validation\Rule;

/**
 * @property-read int $type_idle
 * @property-read int $index_no
 */
class ReqIdleSync extends BaseReq
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'type_idle' => ['required', Rule::enum(TypeIdle::class)],
            'index_no' => 'required|integer',
        ];
    }
}
