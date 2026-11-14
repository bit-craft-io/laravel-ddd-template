<?php

declare(strict_types=1);

namespace App\DataSources;

use BitCraft\Core\DataSources\BaseDs;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DsUItem extends BaseDs
{
    /**
     * @return Model|null
     */
    public function makeDraft(): ?Model
    {
        return $this->_model;
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
     * @param array $values
     * @return void
     */
    public function upsert(array $values): void
    {
        $uniqueBy = ['user_id', 'item_id'];
        $this->_model
            ->newQuery()
            ->upsert($values, $uniqueBy);
    }
}
