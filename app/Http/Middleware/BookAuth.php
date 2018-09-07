<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\Controller;
use App\Models\UserBook;
use Closure;

class BookAuth extends Controller
{
    /**
     * Handle an incoming request.
     * @desc 对账本操作前做的权限判断
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //查找账本是否属于该用户
        $where = [['user_id', $request->user_id], ['book_id', $request->id], ['status', 1]];
        if(UserBook::where($where)->doesntExist()) {
            return $this->response->error('No Authorizations', 422);
        }
        return $next($request);
    }
}
