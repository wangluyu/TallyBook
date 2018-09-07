<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\BookRequest;
use App\Models\Account;
use App\Models\Book;
use App\Models\Fund;
use App\Models\Partner;
use App\Models\PartnerBook;
use App\Models\UserBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    private $book_id = 0;
    /**
     * @desc 创建账本
     * @param BookRequest $request
     * @return mixed
     */
    public function store(BookRequest $request)
    {
        $return = ['status'=>200,'msg'=>'success','data'=>[]];
        //事务开始
        DB::beginTransaction();
        try{
            //新建账本
            $booke_attributes = $request->only(['name', 'location', 'start', 'end']);
            $book = Book::create($booke_attributes);
            $this->book_id = $book['id'];

            //关联账本与用户
            $user_book_attributes = ['user_id'=>$this->user_id,'book_id'=>$this->book_id];
            $user_book = UserBook::create($user_book_attributes);

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

    /**
     * @desc 更新账本信息
     * @param BookRequest $request
     * @return mixed
     */
    public function update(BookRequest $request)
    {
        $return = ['status'=>200,'msg'=>'success','data'=>[]];
        //事务开始
        DB::beginTransaction();
        try{
            $this->book_id = $request->id;
            //更新账本
            $booke_attributes = $request->only(['name', 'location', 'start', 'end']);
            $book = Book::where('id', $this->book_id)->update($booke_attributes);

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

    public function delete(BookRequest $request)
    {
        $return = ['status'=>200,'msg'=>'success','data'=>[]];
        $this->book_id = $request->id;
        DB::beginTransaction();
        try{
            //删除账本
            Book::destroy($this->book_id);
            //删除用户与账本关联
            UserBook::where('book_id',$this->book_id)->delete();
            //删除成员与账本关联
            PartnerBook::where('book_id',$this->book_id)->delete();
            //删除账目与账本关联
            Account::where('book_id',$this->book_id)->delete();
            //删除款项与账本关联
            Fund::where('book_id',$this->book_id)->delete();
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
