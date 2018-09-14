<?php

namespace App\Models;

class Fund extends Model
{
    /**
     * 不可被批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    public function updateFund($book_id = 0, $account_id = 0, $amount = 0, $new = [], $edit = [], $del = [])
    {
        try {
            $date = date('Y-m-d H:i:s');
            if (empty($account_id) || empty($book_id) || empty($amount)) {
                return false;
            }
            if (empty($new) && empty($edit)) {
                return false;
            }
            //查找该账本所有参与人
            $book_parents = PartnerBook::where(['book_id' => $book_id, 'status' => 1])->pluck('partner_id')->toArray();
            $book_parents[] = 0;
            //已支付总额
            $paid_amount = 0;
            //应支付总额
            $should_pay_amount = 0;
            $fund_insert = [];
            $fund_update = [];
            if (!empty($new)) {
                //type为1代表已支付数据，为2代表应支付
                foreach ($new as $n) {
                    if (isset($n['amount']) && in_array($n['partner_id'], $book_parents) && in_array($n['status'], [0, 1, 2]) && in_array($n['type'], [1, 2])) {
                        if (!empty($n['amount'])) {
                            $fund_insert[] = ['book_id' => $book_id,
                                'account_id' => $account_id,
                                'total_amount' => $n['amount'],
                                'type' => $n['type'],
                                'partner_id' => $n['partner_id'],
                                'status' => $n['status'],
                                'created_at' => $date,
                                'updated_at' => $date];
                            if ($n['type'] == 1) {
                                $paid_amount += $n['amount'];
                            } elseif ($n['type'] == 2) {
                                $should_pay_amount += $n['amount'];
                            }
                        }
                    } else {
                        $return['msg'] = '数据错误';
                        throw new \Exception();
                    }
                }
            }

            if (!empty($edit)) {
                //type为1代表已支付数据，为2代表应支付
                foreach ($edit as $e) {
                    if (isset($e['amount']) && in_array($e['status'], [0, 1, 2])) {
                        if (!empty($e['amount'])) {
                            $fund_update[] = [
                                'id'    =>  $e['id'],
                                'total_amount' => $e['amount'],
                                'status' => $e['status'],
                                'updated_at' => $date
                            ];
                            if ($e['type'] == 1) {
                                $paid_amount += $e['amount'];
                            } elseif ($e['type'] == 2) {
                                $should_pay_amount += $e['amount'];
                            }
                        }
                    } else {
                        return '数据错误';
                    }
                }
            }

            if ($paid_amount != $should_pay_amount || $paid_amount != $amount) {
                return '应收应付不相等';
            }
            if (!empty($fund_insert)) {
                self::insert($fund_insert);
            }
            if (!empty($fund_update)) {
                $this->updateBatch($fund_update);
            }
        }catch (\Exception $e){
            return false;
        }
        return true;
    }
}
