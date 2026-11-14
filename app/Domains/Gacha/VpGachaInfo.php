<?php

declare(strict_types=1);

namespace App\Domains\Gacha;

use BitCraft\Core\Domains\ValueProxy\BaseVp;
use Carbon\CarbonImmutable;

/**
 * @method void gacha_info(array $values)
 * @property array $gacha_info
 */
class VpGachaInfo extends BaseVp
{
    // @note gacha_info の構造
    protected array $_gacha_info = [
        'exec_count' => 0,
        'exec_at' => '',
        'expired_at' => '',
    ];

    /**
     * @param int $group_no
     * @return void
     */
    public function addExecCount(int $group_no): void
    {
        $gacha_info = $this->gacha_info;

        if (empty($gacha_info[$group_no])) {
            $gacha_info[$group_no] = $this->_gacha_info;
        }
        $gacha_info[$group_no]['exec_count'] += 1;
        $gacha_info[$group_no]['exec_at'] = CarbonImmutable::now()->toDateTimeString();
        // TODO $vo_gacha->end_at
        //$gacha_info[$group_no]['expired_at'] = $vo_gacha->end_at;

        ksort($gacha_info);
        $this->gacha_info($gacha_info);
    }

    /**
     * @param int $group_no
     * @return int
     */
    public function getExecCount(int $group_no): int
    {
        return $this->gacha_info[$group_no]['exec_count'] ?? 0;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->gacha_info;
    }
}
