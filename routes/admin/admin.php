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
        Route::match(['get', 'post'], 'users/role/{user}','UsersController@role')->name('users.role');

        // 角色管理-资源路由
        // 给角色分配权限
        Route::get('roles/nodes/{role}', 'RolesController@node')->name('roles.node');
        Route::post('roles/nodes/{role}', 'RolesController@nodeSave')->name('roles.node');
        Route::get('roles/restore/{role_id}', 'RolesController@restore')->name('roles.restore');
        Route::delete('roles/delall', 'RolesController@delall')->name('roles.delall');
        Route::resource('roles', 'RolesController');

        // 权限管理-资源路由
        Route::get('nodes/restore/{role_id}', 'NodesController@restore')->name('nodes.restore');
        Route::delete('nodes/delall', 'NodesController@delall')->name('nodes.delall');
        Route::resource('nodes', 'NodesController');

        // 文章管理 admin/article/upfile
        Route::post('articles/upfile','ArticlesController@upfile')->name('articles.upfile');
        // 文章管理
        Route::resource('articles', 'ArticlesController');

        // 房源属性
        // 房源文件上传
        Route::post('fangattrs/upfile', 'FangattrsController@upfile')->name('fangattrs.upfile');
        Route::resource('fangattrs', 'FangattrsController');

        // 房东管理
        Route::post('fangowners/upfile', 'FangownersController@upfile')->name('fangowners.upfile');
        Route::get('fangowners/delfile', 'FangownersController@delfile')->name('fangowners.delfile');
        Route::get('fangowners/export/', 'FangownersController@export')->name('fangowners.export');
        // 房东-全选删除
        Route::delete('fangowners/delall', 'FangownersController@delall')->name('fangowners.delall');
        Route::resource('fangowners', 'FangownersController');

        // 房源管理
        // 房源文件上传
        Route::delete('fangs/delall', 'FangsController@delall')->name('fangs.delall');
        Route::patch('fangs/changestatus', 'FangsController@changestatus')->name('fangs.changestatus');
        Route::post('fangs/upfile', 'FangsController@upfile')->name('fangs.upfile');
        Route::get('fangs/delfile', 'FangsController@delfile')->name('fangs.delfile');
        Route::get('fangs/city', 'FangsController@city')->name('fangs.city');
        Route::resource('fangs', 'FangsController');

        // 楼盘管理
        Route::resource('houses', 'HousesController');

        // 广告管理
        // 轮播图管理
        Route::resource('advimgs', 'AdvimgsController');
    });


});