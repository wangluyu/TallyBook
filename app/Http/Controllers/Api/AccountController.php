<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AccountRequest;
use App\Models\Account;
use App\Models\Fund;
use App\Models\PartnerBook;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * @desc 添加账目
     * @param AccountRequest $request
     * @return mixed
     */
    public function store(AccountRequest $request)
    {
        $return = $this->return;
        //事务开始
        DB::beginTransaction();
        try{
            $account_attributes = $request->only(['tag_id', 'amount', 'note', 'location', 'timestamp']);
            $account_attributes['book_id'] = $request->id;
            $account_attributes['created_at']   =   $date;
            $account_attributes['updated_at']   =   $date;
            $pay = $request->pay;
            //判断账目类型是否存在
            $where = [
                'id'  =>  $account_attributes['tag_id']
            ];
            if(Tag::where($where)->whereIn('user_id', [0, $this->user_id])->doesntExist()){
                $return['msg'] = '类型不存在';
                throw new \Exception();
            }

            //新建账目
            $account_id = Account::insertGetId($account_attributes);

            //提交事务
            DB::commit();
        }catch (\Exception $e) {
            //回滚
            DB::rollBack();
            $return['status'] = 400;
            if ($return['msg'] == 'success'){
                $return['msg'] = $e->getMessage();
            }
        }
        return $this->response->array($return);
    }

    /**
     * @desc 删除账目
     * @param AccountRequest $request
     * @return mixed
     */
    public function delete(AccountRequest $request)
    {
        $return = $this->return;
        //事务开始
        DB::beginTransaction();
        try{
            $id = $request->id;
            $force = intval($request->force) === 1 ? true : false;
            if(!$force){
                $where = [
                    "account_id"    =>  $id,
                    "status"    =>  0
                ];
                if(Fund::where($where)->exists()){
                    $return['msg'] = '还有未结清款项，确定删除？';
                    throw new \Exception();
                }
            }

            //删除款项
            Fund::where('account_id',$id)->delete();
            //删除账目
            Account::destroy($id);
            //提交事务
            DB::commit();
        }catch (\Exception $e) {
            //回滚
            DB::rollBack();
            $return['status'] = 400;
            if ($return['msg'] == 'success'){
                $return['msg'] = $e->getMessage();
            }
        }
        return $this->response->array($return);
    }

    public function update(AccountRequest $request)
    {
        $return = $this->return;
        //事务开始
        DB::beginTransaction();
        try{
            //提交事务
            DB::commit();
        }catch (\Exception $e) {
            //回滚
            DB::rollBack();
            $return['status'] = 400;
            if ($return['msg'] == 'success'){
                $return['msg'] = $e->getMessage();
            }
        }
        return $this->response->array($return);
    }
}
