<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\FundRequest;
use App\Models\Fund;

class FundController extends Controller
{
    public function unpaid(FundRequest $request){
        $return = ['status'=>'200', 'msg'=>'success', 'data'=>array()];
        $book_id = $request->book_id;
        $partner_id = $request->partner_id;
        $where = [
            ['book_id', $book_id],
            ['partner_id', $partner_id],
            ['status','!=',1]
        ];
        $return['data'] = Fund::select('id', 'total_amount', 'type', 'status')->where($where)->get()->toArray();
        return $this->response->array($return);
    }
}
