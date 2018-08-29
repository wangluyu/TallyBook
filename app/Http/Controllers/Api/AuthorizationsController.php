<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\WechatLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class AuthorizationsController extends Controller
{
    public function serve(WechatLoginRequest $request)
    {
        $code = $request->code;
        $miniProgram = \EasyWeChat::miniProgram(); // 小程序
        $result = $miniProgram->auth->session($code);
        //如果没有openid和session key，返回错误
        if (!isset($result['openid']) || !isset($result['session_key'])) {
            $this->response->error($result['errmsg'], 422);
        }
        //事务开始
        DB::beginTransaction();
        try {
            $open_id = $result['openid'];
            $session_key = $result['session_key'];
            // 通过 openid 检索users表，如果不存在则创建
            $user = User::firstOrCreate(['openId' => $open_id]);
            //将session key与user_id存进redis，过期时间为2小时
            $flag = Redis::hset(config('const.wechat_session'), $session_key, $user['id']);
            if (!$flag) {
                throw new \Exception("redis hset error:$flag");
            }
            //返回session key
            $return['session'] = $result['session_key'];
            //提交事务
            DB::commit();
        }catch (\Exception $e) {
            //回滚
            DB::rollBack();
            $return = $e->getMessage();
        }
        $this->response->array($return);
    }
}
