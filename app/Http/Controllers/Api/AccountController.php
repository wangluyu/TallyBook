<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AccountRequest;
use App\Models\Account;
use App\Models\PartnerBook;
use App\Models\Tag;

class AccountController extends Controller
{
    public function store(AccountRequest $request)
    {
        $return = $this->return;
        //事务开始
        DB::beginTransaction();
        try{
            $account_attributes = $request->only(['tag_id', 'amount', 'note', 'location', 'timestamp']);
            $account_attributes['book_id'] = $request->id;
            $paid = $request->paid;
            $should_pay = $request->should_pay;
            //判断账目类型是否存在
            $where = [
                'id'  =>  $account_attributes['tag_id'],
                'user_id'   =>  $this->user_id
            ];
            if(Tag::where($where)->doesntExist()){
                $return['msg'] = '类型不存在';
                throw new \Exception();
            }

            //新建账目
            $account_id = Account::create($account_attributes);
            //查找该账本所有参与人
            $book_parents = PartnerBook::where(['book_id',$request->id],['status',1])->pluck('partner_id');
            //已支付总额
            $paid_amount = 0;
            //应支付总额
            $should_pay_amount = 0;
            $fund_attributes = [];
            //已支付数据
            foreach ($paid as $p){
                if (isset($p['amount']) && in_array($p['partner_id'],$book_parents) && isset($p['status'])){
                    if(!empty($p['amount'])){
                        $paid_amount += $p['amount'];
                        $fund_attributes[] = 
                    }
                }
            }
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
