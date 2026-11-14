<?php

declare(strict_types=1);

namespace App\Http\Responses\Item;

use BitCraft\Core\Http\Requests\ReqNone;
use BitCraft\Core\Http\Responses\BaseRes;
use App\Domains\RepHub;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResItemGet extends BaseRes
{
    /**
     * @param Request|ReqNone $req
     * @return JsonResponse
     */
    public function toResponse(Request|ReqNone $req): JsonResponse
    {
        $rep_item = $this->_Domain::rep(RepHub::REP_ITEM);
        $ent_items = $rep_item->getByUserId($req->user_id);
        foreach ($ent_items as $ent_item) {
            $this->_result['items'][] = $ent_item->toArray();
        }

        return response()
            ->json([
                'success' => 1,
                'result' => (object)$this->_result,
            ]);
    }
}
