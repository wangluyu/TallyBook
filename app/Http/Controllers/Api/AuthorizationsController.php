<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\WechatLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Common\AES;

class AuthorizationsController extends Controller
{
    public function wechatStore(WechatLoginRequest $request)
    {
        $code = $request->code;
        $miniProgram = \EasyWeChat::miniProgram(); // 小程序
        $result = $miniProgram->auth->session($code);
        //如果没有openid和session key，返回错误
        if (!isset($result['openid']) || !isset($result['session_key'])) {
            return $this->response->error($result['errmsg'], 422);
        }
        //事务开始
        DB::beginTransaction();
        try {
            $open_id = $result['openid'];
            $session_key = $result['session_key'];
            // 通过 openid 检索users表，如果不存在则创建
            $user = User::firstOrCreate(['open_id' => $open_id]);
            if (empty($user['id'])) {
                throw new \Exception("user info error");
            }
            //加密session
            $session_key = AES::encrypt($user['id'].'_'.$session_key);
            //将session key与user_id存进redis，过期时间为2小时
            $redis_config = config('const.redis');
            $redis_key = $redis_config['wechat_session'].'_'.$user['id'];
            $redis_expiration = $redis_config['wechat_session_expiration'];
            $flag = Redis::set($redis_key, $session_key, 'EX', $redis_expiration);
            if (!$flag) {
                throw new \Exception("redis hset error:$flag");
            }
            //返回session key
            $return['result'] = $result;
            $return['user'] = $user;
            $return['session'] = $session_key;
            //提交事务
            DB::commit();
        }catch (\Exception $e) {
            //回滚
            DB::rollBack();
            $return = $e->getMessage();
        }
        return $this->response->array($return);
    }
}
