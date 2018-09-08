<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\PartnerBookRequest;
use App\Models\PartnerBook;
use Illuminate\Http\Request;

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
            $this->book_id = $request->id;
            $partners = $request->partner;
            //更新账本与成员关联
            PartnerBook::updatePartnerBookList($partners, $this->user_id, $this->book_id);
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
}
