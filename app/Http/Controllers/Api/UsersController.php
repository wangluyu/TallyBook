<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Requests\Api\UserRequest;


class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        return $this->response->created();
    }

    public function update(UserRequest $request)
    {
        $return = ['status'=>200,'msg'=>'success','data'=>[]];
        return $this->response->array($request);
        //事务开始
        DB::beginTransaction();
        try{
            $user_id = $request->user_id;
            $attributes = $request->only(['name', 'email', 'phone', 'avatar', 'gender', 'city', 'province', 'country', 'language']);
            $user = User::find($user_id);
            $user->update($attributes);
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
