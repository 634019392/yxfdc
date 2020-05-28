<?php
// 后台路由

// 路由分组
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    // 登录页面 显示
    Route::get('login', 'LoginsController@index')->name('login');
    // 登录功能
    Route::post('login', 'LoginsController@login')->name('login');

    // 管理员
    Route::group(['middleware' => ['ckadmin']], function () {
        // 后台主页 显示
        Route::get('index', 'IndexsController@index')->name('index');
        // 欢迎页面 显示
        Route::get('welcome', 'IndexsController@welcome')->name('welcome');
        // 后台用户退出
        Route::get('logout', 'LoginsController@logout')->name('logout');

        // 用户管理 -------------
        // 用户列表页面 显示
        Route::get('users/index', 'UsersController@index')->name('users.index');
        // 用户列表-用户添加
        Route::get('users/add', 'UsersController@create')->name('users.create');
        Route::post('users/add', 'UsersController@store')->name('users.store');
        // 用户列表-用户编辑
        Route::get('users/edit/{user}', 'UsersController@edit')->name('users.edit');
        Route::put('users/edit/{user}', 'UsersController@update')->name('users.update');

        // 用户软删除
        Route::delete('users/destroy/{user}', 'UsersController@destroy')->name('users.destroy');
        // 用户还原
        Route::get('users/restore/{user_id}', 'UsersController@restore')->name('users.restore');
        // 全选软删除
        Route::delete('users/delall', 'UsersController@delall')->name('users.delall');

        // 角色管理-资源路由
        Route::get('roles/restore/{role_id}', 'RolesController@restore')->name('roles.restore');
        Route::delete('roles/delall', 'RolesController@delall')->name('roles.delall');
        Route::resource('roles', 'RolesController');

        // 权限管理-资源路由
        Route::get('nodes/restore/{role_id}', 'NodesController@restore')->name('nodes.restore');
        Route::delete('nodes/delall', 'NodesController@delall')->name('nodes.delall');
        Route::resource('nodes', 'NodesController');


    });


});