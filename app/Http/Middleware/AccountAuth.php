<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\Controller;
use App\Models\UserBook;
use Closure;
use Illuminate\Support\Facades\DB;

class AccountAuth extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        DB::enableQueryLog();
//        //查找账本是否属于该用户
//        $where = [['user_id', $request->user_id], ['accounts.id', $request->id], ['user_books.status', 1]];
//        if(UserBook::where($where)->join('accounts', 'accounts.book_id', '=', 'user_books.book_id')->doesntExist()) {
//            $sql = DB::getQueryLog();
//            $query = end($sql);
//            return $this->response->error($query, 422);
//        }
        return $next($request);
    }
}
