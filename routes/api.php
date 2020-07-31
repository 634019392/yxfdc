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

// 说明：定义在api.php文件中的路由，默认就有了一个前缀，api

// 定义登录路由
// 访问路由  api/login 测试控制器已移除
Route::post('login','Api\LoginController@login');

Route::group(['prefix'=>'v1','namespace'=>'Api'],function (){
    // 小程序登录
    Route::post('swxlogin','LoginController@swxlogin');

    // 所有楼盘信息
    Route::get('houses/index', 'HousesController@index');
    // 楼盘详情
    Route::get('houses/show', 'HousesController@show');

    Route::get('advs/img', 'AdvsController@img');
});

// 请求验证
// 符合restful标准
// uri 独立域名或能区别的前缀 api
// uri最好有版本
// 结果用名词不用动词
// 内容可以用 rsa非对称加密 https://blog.csdn.net/haibo0668/article/details/81489217
Route::group(['middleware'=>'auth:api','prefix'=>'v1','namespace'=>'Api'],function (){

    Route::post('user', 'LoginController@user');

    // 获取手机号
    Route::post('check_data/phone_num', 'CheckDataController@phone_num');

    // 认证上传身份证$request->route()->getAction();
    Route::post('users/upfile', 'UsersController@upfile');
    Route::post('users/mysql_user', 'UsersController@mysql_user');

    // 经纪人---
    // 发送手机验证码
    Route::post('bokers/send_code', 'BokersController@send_code');
    // 认证
    Route::post('bokers/check', 'BokersController@check');
    // 推荐客户功能
    Route::post('bokers/reave', 'BokersController@reave');
    // 我的客户
    Route::post('bokers/my_client', 'BokersController@my_client');

    // 参与全民经纪人楼盘
    Route::get('houses/boker_houses', 'HousesController@boker_houses');

});