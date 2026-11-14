<?php

declare(strict_types=1);

namespace App\DataSources;

use BitCraft\Core\DataSources\BaseDs;
use App\Models\UIdle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DsUIdle extends BaseDs
{
    /**
     * @param array $values
     * @return Model|null
     */
    public function makeDraft(array $values): ?Model
    {
        return $this->_model->newInstance($values);
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

    /**
     * @param int $user_id
     * @param int $type_idle
     * @param int $index_no
     * @return UIdle|null
     */
    public function findByUnique(int $user_id, int $type_idle, int $index_no): ?UIdle
    {
        return $this->_model
            ->newQuery()
            ->where('user_id', $user_id)
            ->where('type_idle', $type_idle)
            ->where('index_no', $index_no)
            ->first();
    }
}
