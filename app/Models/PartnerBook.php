<?php

namespace App\Models;

class PartnerBook extends Model
{

    /**
     * 不可被批量赋值的属性。
     * @var array
     */
    protected $guarded = [];

    /**
     * @desc 添加更新成员，关联账本与成员
     * @param string $partnerStr
     * @param int $user_id
     * @param int $book_id
     */
    public static function updatePartnerBookList(string $partnerStr, int $user_id, int $book_id)
    {
        if (!empty($partnerStr) && !empty($user_id) && !empty($book_id)) {
            $date = date('Y-m-d H:i:s');
            //查找该用户所有的成员
            $partner_model = new Partner();
            $partner_belongs_user = $partner_model->getByUser($user_id);
            $partnersArr = explode(',', $partnerStr);
            $new_partner_attributes = [];
            $update_partner_attributes = [];
            $partner_book_attributes = [];
            foreach ($partnersArr as $p) {
                //不需要新增partner表
                if(is_numeric($p)) {
                    //如果partner_id属于用户，并且是可用的
                    if(isset($partner_belongs_user[$p]) && $partner_belongs_user[$p]['status'] == 1) {
                        //需要插入partner_book的数据
                        $partner_book_attributes[$p] = ['book_id'=>$book_id,'partner_id'=>$p];
                    }
                }else {//需要新增到partner表
                    $flag = true;
                    foreach ($partner_belongs_user as $pbu_id => $pbu_value) {
                        //如果需要新增的成员已存在
                        if($p == $pbu_value['name']){
                            $flag = true;
                            $partner_book_attributes[$p] = ['book_id'=>$book_id,'partner_id'=>$p];
                            //并且状态是不可用
                            if($pbu_value['status'] == 0){
                                $update_partner_attributes[$pbu_id] = ['status'=>1,'updated_time'=>$date];
                            }
                            break;
                        }
                    }
                    if ($flag){
                        //需要新增的成员
                        $new_partner_attributes[] = ['user_id'=>$user_id,'name'=>$p];
                    }
                }
            }
            //新增成员
            $new_partners = $partner_model->createBatch($new_partner_attributes);
            //更新成员状态
            $update_partners = $partner_model->update($update_partner_attributes);
            //将新增的成员与账本关联
            foreach ($new_partners as $p){
                $partner_book_attributes[] = ['book_id'=>$book_id,'partner_id'=>$p];
            }
            $partner_book_model = new PartnerBook();
            $partner_book = $partner_book_model->createBatch($partner_book_attributes);
        }
    }
}
