<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\PartnerBookRequest;
use Illuminate\Http\Request;

class PartnerBookController extends Controller
{
    private $book_id = 0;

    public function update(PartnerBookRequest $request)
    {
        $return = ['status'=>200,'msg'=>'success','data'=>[]];
        //事务开始
        DB::beginTransaction();
        try{
            $this->book_id = $request->id;
            //更新账本与成员关联
            $partner_book_attributes = $request->only(['add', 'delete']);

            $book = Book::where('id', $this->book_id)->update($partner_book_attributes);

            $return['data'] = $this->book_id;

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
