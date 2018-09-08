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

    //需要登录后的操作
    $api->group(['middleware' => ['auth.wechat']], function ($api) {
        //测试用
        $api->get('test', 'TestController@test')
            ->name('api.test.test');

        // 编辑用户信息
        $api->put('user', 'UsersController@update')
            ->name('api.user.update');

        //添加账本
        $api->post('book', 'BookController@store')
            ->name('api.book.store');

        //添加账目
        $api->post('account', 'AccountController@store')
            ->name('api.account.store');

        //需要验证用户账本权限的操作
        $api->group(['middleware' => ['auth.book']], function ($api) {
            //修改账本信息
            $api->put('book', 'BookController@update')
                ->name('api.book.update');
            //删除账本
            $api->delete('book', 'BookController@delete')
                ->name('api.book.delete');
            //添加参与人
            $api->post('partner_book', 'PartnerBookController@store')
                ->name('api.partner_book.store');
        });
    });

});
