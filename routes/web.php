<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Wechat'], function() {
    Route::any('/wechat', 'WeChatController@serve');
});

Route::get('/', function () {
    return 'this is a home';
});

Route::get('/test', 'TestsController@test');

// 房产资讯（公告栏）内容h5渲染
Route::get('/board/content/{board}', function (\App\Models\Board $board) {
    return view('board.index', compact('board'));
})->name('board');

include base_path('routes/admin/admin.php');
include base_path('routes/other/crawl.php');

Route::post('admin/upfile', 'PhotosController@upfile')->name('admin.upfile');
Route::post('admin/delfile', 'PhotosController@delfile')->name('admin.delfile');
Route::post('admin/delfilesql', 'PhotosController@delfilesql')->name('admin.delfilesql');