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

        // 楼盘-全民营销活动参数配置
        Route::post('houses/act_param', 'HousesController@act_param_store')->name('houses.act_param.store');
        Route::put('houses/act_param/{actParam}', 'HousesController@act_param_update')->name('houses.act_param.update');
        Route::get('houses/act_param/{actParam}/edit', 'HousesController@act_param_edit')->name('houses.act_param.edit');
        // 楼盘管理
        Route::resource('houses', 'HousesController');

        // 广告管理
        // 轮播图管理
        Route::resource('advimgs', 'AdvimgsController');

        // 全民营销
        // 客户列表
        Route::post('buyers/export', 'BuyersController@export')->name('buyers.export');
        Route::get('buyers/index', 'BuyersController@index')->name('buyers.index');
        // 客户状态编辑
        Route::get('buyers/{recommender}/edit', 'BuyersController@edit')->name('buyers.edit');
        Route::put('buyers/{recommender}', 'BuyersController@update')->name('buyers.update');
        // 客户跟踪-客户记录列表渲染-客户记录新增功能
        Route::get('buyers/{recommender}/tail', 'BuyersController@tail')->name('buyers.tail');
        Route::post('buyers/{recommender}/tail_create', 'BuyersController@tail_create')->name('buyers.tail_create');
        // 客户跟踪-客户记录更新功能
        Route::put('buyers/tail/{clientRecord}', 'BuyersController@tail_update')->name('buyers.tail_update');

        // 公告栏
        Route::get('boards/create_news', 'BoardsController@create_news')->name('boards.create_news');
        Route::any('boards/wechat_gather', 'BoardsController@wechat_gather')->name('boards.wechat_gather');
        Route::post('boards/store_news', 'BoardsController@store_news')->name('boards.store_news');
        Route::resource('boards', 'BoardsController');
    });


});