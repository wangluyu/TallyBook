<?php

namespace App\Http\Middleware;

use App\Common\AES;
use App\Http\Controllers\Api\Controller;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Redis;

class WechatAuth extends Controller
{
    public $user_id = 0;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //test
        $this->user_id = 1;
        $request['user_id'] = 1;
        return $next($request);
        $session = $_SERVER['HTTP_SESSION'] ?? 0;
        if (empty($session)) {
            return $this->response->error('No Authorizations1', 422);
        }

        //对session进行解密，得到userId_sessionKey
        $session = AES::decrypt($session);
        $tmp = explode('_',$session,2);
        $user_id = $tmp[0] ?? 0;
        $session_key = $tmp[1] ?? 0;
        if (empty($user_id) || empty($session_key)) {
            return $this->response->error('No Authorizations2', 422);
        }
        //从redis里获取session_key
        $redis_config = config('const.redis');
        $redis_key = $redis_config['wechat_session'].'_'.$user_id;
        $redis_session_key = Redis::get($redis_key);
        //比较用户传过来的session与redis的session_key是否相等
        if (!hash_equals($session_key, $redis_session_key)){
            return $this->response->error('No Authorizations3', 422);
        }
        //根据user_id判断用户状态
        $user = User::find($user_id);
        if ($user['status'] != 1) {
            return $this->response->error('No Authorizations4', 422);
        }
        $request['user_id'] = $user_id;
        return $next($request);
    }
}
