<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api'
], function($api) {
    //小程序登录
    $api->get('wechat', 'WeChatController@serve')
        ->name('api.wechat.serve');
    $api->post('wechat/authorizations', 'AuthorizationsController@wechatStore')
        ->name('api.wechat.authorizations.store');
    // 短信验证码
    $api->post('verificationCodes', 'VerificationCodesController@store')
        ->name('api.verificationCodes.store');
    //注册
    $api->post('users', 'UsersController@store')
        ->name('api.users.store');
});
