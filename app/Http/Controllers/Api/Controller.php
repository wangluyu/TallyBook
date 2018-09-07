<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    use Helpers;

    public $user_id = 0;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user_id = $request->user_id;
            return $next($request);
        });
    }
}