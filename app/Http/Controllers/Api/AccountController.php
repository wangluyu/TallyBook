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
    public function store(AccountRequest $request)
    {
        $date = date('Y-m-d H:i:s');
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
            //查找该账本所有参与人
            $book_parents = PartnerBook::where(['book_id'=>$request->id,'status'=>1])->pluck('partner_id')->toArray();
            $book_parents[] = 0;
            //已支付总额
            $paid_amount = 0;
            //应支付总额
            $should_pay_amount = 0;
            $fund_attributes = [];
            $return['data'] = $pay;
            //type为1代表已支付数据，为2代表应支付
            foreach ($pay as $p){
                if (isset($p['amount']) && in_array($p['partner_id'],$book_parents) && in_array($p['status'], [0,1,2]) && in_array($p['type'],[1,2])){
                    if(!empty($p['amount'])){
                        $fund_attributes[] = ['book_id'=>$request->id,
                            'account_id'=>$account_id,
                            'total_amount'=>$p['amount'],
                            'type'  =>  $p['type'],
                            'partner_id'=>$p['partner_id'],
                            'status'=>$p['status'],
                            'created_at'=>$date,
                            'updated_at'=>$date];
                        if ($p['type'] == 1){
                            $paid_amount += $p['amount'];
                        }elseif($p['type'] == 2){
                            $should_pay_amount += $p['amount'];
                        }
                    }
                } else {
                    $return['msg'] = '数据错误';
                    throw new \Exception();
                }
            }
            if ($paid_amount != $should_pay_amount || $paid_amount != $account_attributes['amount']){
                $return['msg'] = '应收应付不相等';
                throw new \Exception();
            }
            Fund::insert($fund_attributes);
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
