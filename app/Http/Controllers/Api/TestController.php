<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function test(Request $request)
    {
        if(!empty($request)){
            echo "BOaaaa";
        }else {
            echo "BO";
        }
    }
}
