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
        //获取账目类型
        $api->get('tags', 'TagController@get')
            ->name('api.tag.get');
        //添加账目类型
        $api->post('tags', 'TagController@store')
            ->name('api.tag.store');
        //修改账目类型
        $api->put('tags', 'TagController@update')
            ->name('api.tag.update');
        //删除账目类型
        $api->delete('tags', 'TagController@delete')
            ->name('api.tag.delete');

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
            //删除参与人
            $api->delete('partner_book', 'PartnerBookController@delete')
                ->name('api.partner_book.delete');
            //检查是否有未付款项
            $api->get('check_unpaid', 'FundController@unpaid')
                ->name('api.fund.unpaid');
        });
    });
});
