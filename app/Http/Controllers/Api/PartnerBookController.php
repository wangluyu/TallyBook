<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\PartnerBookRequest;
use App\Models\Fund;
use App\Models\PartnerBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnerBookController extends Controller
{
    private $book_id = 0;

    /**
     * @desc 添加参与人
     * @param PartnerBookRequest $request
     * @return mixed
     */
    public function store(PartnerBookRequest $request)
    {
        $return = ['status'=>200,'msg'=>'success','data'=>[]];
        //事务开始
        DB::beginTransaction();
        try{
            $this->book_id = $request->book_id;
            $partner = $request->partner;
            //更新账本与成员关联
            PartnerBook::updatePartnerBookList($partner, $this->user_id, $this->book_id);
            //提交事务
            DB::commit();
        }catch (\Exception $e) {
            //回滚
            DB::rollBack();
            $return['status'] = 400;
            $return['msg'] = $e->getMessage();
        }
        return $this->response->array($return);
    }

    /**
     * @desc 删除成员
     * @param PartnerBookRequest $request
     * @return mixed
     */
    public function delete(PartnerBookRequest $request){
        $return = ['status'=>'200', 'msg'=>'success', 'data'=>array()];
        //事务开始
        DB::beginTransaction();
        try {
            $book_id = $request->book_id;
            $partner_id = $request->partner_id;
            $where = [
                ['book_id', $book_id],
                ['partner_id', $partner_id]
            ];
            $check_where = $where;
            $check_where[] = ['status','!=',1];
            if(Fund::where($check_where)->exists()){
                $return['msg'] = '还有未结清的款项';
                throw new \Exception();
            }
            PartnerBook::where($where)->update(['status' => 0]);
            DB::commit();
        }catch (\Exception $e) {
            //回滚
            DB::rollBack();
            $return['status'] = 400;
        }
        return $this->response->array($return);
    }
}
