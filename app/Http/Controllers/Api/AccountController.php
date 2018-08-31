<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AccountRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function store(AccountRequest $request)
    {
        echo "a";
    }
}
