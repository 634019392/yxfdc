<?php
// 后台路由

// 路由分组
Route::group(['prefix' => 'crawl', 'namespace' => 'Crawl', 'as' => 'crawl.'], function () {
    route::get('index', 'IndexsController@index')->name('index');

});