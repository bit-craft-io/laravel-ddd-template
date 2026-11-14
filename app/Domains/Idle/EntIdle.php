<?php

declare(strict_types=1);

namespace App\Domains\Idle;

use BitCraft\Core\Domains\Entity\BaseEnt;
use App\Models\Enum\TypeItem;
use Carbon\CarbonImmutable;

/**
 * @method void id(int $value)
 * @method void user_id(int $value)
 * @method void type_idle(int $value)
 * @method void index_no(int $value)
 * @method void progress_id(string $value)
 * @method void begin_at(string $value)
 * @method void end_at(string $value)
 * @method void end_forward_sec(int $value)
 * @method void stash_contents(array $value)
 * @property-read integer $id
 * @property-read integer $user_id
 * @property-read TypeItem $type_idle
 * @property-read integer $index_no
 * @property-read string|null $progress_id
 * @property-read object|null $begin_at
 * @property-read object|null $end_at
 * @property-read integer $end_forward_sec
 * @property-read array $stash_contents
 */
class EntIdle extends BaseEnt
{
    protected VpStashContents $_vp_stash_contents;

    public function initOnce(): void
    {
        // TODO: Implement initOnce() method.
    }

    public function initAfter(): void
    {
        $this->_vp_stash_contents = $this->_Domain::vo(VpHub::VP_STASH_CONTENTS)->init($this);
    }

    public function isEmpty(): bool
    {
        return ($this->id ?? 0) == 0;
    }

    public function info(): array
    {
//        $intervalMinutes = $playerRank::RECOVER_INTERVAL_MINUTES;
//        $numPerInterval = $playerRank::RECOVER_NUM_PER_INTERVAL;
        // TODO 定数に変更
        $num_max = 100;
        $interval_minutes = 1;
        $num_per_interval = 1;

//        $add_num = 0;
//        $recover_max_at = $this->begin_at->toDateTimeString();

        $diff_seconds = CarbonImmutable::now()->getTimestamp() - $this->begin_at->getTimestamp();
        // TODO 定数に変更
        $diff_minutes = $diff_seconds / 60;
        $interval_count = (int)floor($diff_minutes / $interval_minutes);
        $add_num = $interval_count * $num_per_interval;
        $add_num = min($add_num, $num_max);
        $require_num_to_max = max(0, $num_max - $add_num);
        $interval_count_max = (int)ceil($require_num_to_max / $num_per_interval);
        // TODO 定数に変更
        $seconds_to_full = $interval_count_max * $interval_minutes * 60;
        $recover_max_at = $this->begin_at->addSeconds($seconds_to_full)->toDateTimeString();

        return [
            'add_num' => $add_num,
            'num_max_at' => $recover_max_at,
            'num_max' => $num_max,
            'interval_minutes' => $interval_minutes,
            'num_per_interval' => $num_per_interval,
            'can_recover' => $add_num >= 1
        ];

    }

    public function toArray(): array
    {
        return [
            'type_idle' => $this->type_idle->value,
            'index_no' => $this->index_no,
            'progress_id' => $this->progress_id,
            'begin_at' => $this->begin_at,
            'end_at' => $this->end_at,
            'end_forward_sec' => $this->end_forward_sec,
        ];
    }
}
