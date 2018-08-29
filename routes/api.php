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
    $api->get('wechat/authorizations', 'AuthorizationsController@wechatStore')
        ->name('api.wechat.authorizations.store');

    // 短信验证码
    $api->post('verificationCodes', 'VerificationCodesController@store')
        ->name('api.verificationCodes.store');

    $api->get('test', 'TestController@test')
        ->name('api.test.test');
    //注册
    $api->post('users', 'UsersController@store')
        ->name('api.user.store');

    $api->group(['middleware' => ['auth.wechat']], function ($api) {
        //测试用
        $api->get('authtest', 'TestController@test')
            ->name('api.test.test');

        // 编辑用户信息
        $api->put('user', 'UsersController@update')
            ->name('api.user.update');
    });

});
