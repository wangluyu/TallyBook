<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\WechatRequest;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    public function server(WechatRequest $request)
    {
        $code = $request->code;
        $miniProgram = EasyWeChat::miniProgram(); // 小程序
        $result = $miniProgram->auth->session($code);
        return $this->response->array($result);
    }
}
