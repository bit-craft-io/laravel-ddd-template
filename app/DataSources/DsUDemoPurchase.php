<?php

declare(strict_types=1);

namespace App\DataSources;

use BitCraft\Core\DataSources\BaseDs;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * デモ購入履歴のデータソース
 *
 * u_demo_purchases を読み書きする。
 */
class DsUDemoPurchase extends BaseDs
{
    /**
     * @param int $user_id
     * @return Model|null
     */
    public function makeDraft(int $user_id): ?Model
    {
        return $this->_model->newInstance(['user_id' => $user_id]);
    }

    /**
     * @param int $user_id
     * @return Collection
     */
    public function getByUserId(int $user_id): Collection
    {
        return $this->_model
            ->newQuery()
            ->where('user_id', $user_id)
            ->get();
    }
}
