<?php

declare(strict_types=1);

namespace App\Http\Responses\Item;

use BitCraft\Core\Http\Responses\BaseRes;
use App\Domains\RepHub;
use App\Http\Requests\Item\ReqItemFind;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResItemFind extends BaseRes
{
    /**
     * @param Request|ReqItemFind $req
     * @return JsonResponse
     * @throws Exception
     */
    public function toResponse(Request|ReqItemFind $req): JsonResponse
    {
        $rep_item = $this->_Domain::rep(RepHub::REP_ITEM);
        $ent_item = $rep_item->findOrFail($req->user_id, $req->item_id);
        $this->_result['items'][] = $ent_item->toArray();

        return response()
            ->json([
                'success' => 1,
                'result' => (object)$this->_result,
            ]);
    }
}
