<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function test(Request $request)
    {
        if(!empty($request)){
            var_dump($request);
        }else {
            echo "BO";
        }
    }
}
