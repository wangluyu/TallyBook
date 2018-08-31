<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\BookRequest;
use App\Models\Book;
use App\Models\Partner;
use App\Models\PartnerBook;
use App\Models\UserBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function store(BookRequest $request)
    {
        $return = ['status'=>200,'msg'=>'success','data'=>[]];
        //事务开始
        DB::beginTransaction();
        try{
            $user_id = $request->user_id;
            $partnerStr = $request->partners ?? '';

            //新建账本
            $booke_attributes = $request->only(['name', 'location', 'start', 'end']);
            $book = Book::create($booke_attributes);

            //关联账本与用户
            $user_book_attributes = ['user_id'=>$user_id,'book_id'=>$book['id']];
            $user_book = UserBook::create($user_book_attributes);

            //添加成员
            if (!empty($partnerStr)) {
                //查找该用户所有的成员
                $partner_model = new Partner();
                $partner_ids_belongs_user = $partner_model->getIdByUser($user_id);
                $partnersArr = explode(',', $partnerStr);
                $partner_attributes = [];
                $partner_book_attributes = [];
                foreach ($partnersArr as $p) {
                    if(is_numeric($p)) {
                        //如果partner_id属于用户
                        if(in_array($p,$partner_ids_belongs_user)) {
                            //需要插入partner_book的数据
                            $partner_book_attributes[] = ['book_id'=>$book['id'],'partner_id'=>$p];
                        }
                    }else {
                        //需要新增的成员
                        $partner_attributes[] = ['user_id'=>$user_id,'name'=>$p];
                    }
                }
                //新增成员
                $partners = $partner_model->createBatch($partner_attributes);
                //将新增的成员与账本关联
                foreach ($partners as $p){
                    $partner_book_attributes[] = ['book_id'=>$book['id'],'partner_id'=>$p];
                }
                $partner_book_model = new PartnerBook();
                $partner_book = $partner_book_model->createBatch($partner_book_attributes);
            }
            $return['data'] = $book['id'];

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
