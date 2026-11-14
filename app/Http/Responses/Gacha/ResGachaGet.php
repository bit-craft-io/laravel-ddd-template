<?php

declare(strict_types=1);

namespace App\Http\Responses\Gacha;

use BitCraft\Core\Http\Requests\ReqNone;
use BitCraft\Core\Http\Responses\BaseRes;
use App\Domains\Gacha\VoHub;
use App\Domains\RepHub;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ResGachaGet extends BaseRes
{
    /**
     * @param Request|ReqNone $req
     * @return JsonResponse
     */
    public function toResponse(Request|ReqNone $req): JsonResponse
    {
        $rep_gacha = $this->_Domain::rep(RepHub::REP_GACHA);
        $ent_gacha = $rep_gacha->find($req->user_id);
        $this->_result['u_gacha'] = $ent_gacha->toArray();

        // @note Modelにビジネスロジックのメソッドを追加も可能であるが
        //       インフラ層にビジネスロジックが入ると結合度が高くなる為
        //       Voのビジネスロジックとイテレータで表現
        $vo_gachas = $this->_Domain::mstVo(VoHub::VO_M_GACHA)->get();
        foreach ($vo_gachas as $vo_gacha) {
            $vo_gacha->findOrFail($vo_gacha->id);
            if (!$vo_gacha->validate()) {
                continue;
            }
            if ($vo_gacha->type_draw->isStep()) {
                if ($vo_gacha->exec_count !== $ent_gacha->getExecCount($vo_gacha->group_no)) {
                    continue;
                }
            }
            $this->_result['gachas'][] = $vo_gacha->toArray();
        }

        return response()
            ->json([
                'success' => 1,
                'result' => (object)$this->_result,
            ]);
    }
}
