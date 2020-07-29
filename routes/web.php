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

Route::get('/', function () {
    return 'this is a home';
});

include base_path('routes/admin/admin.php');

Route::post('admin/upfile', 'PhotosController@upfile')->name('admin.upfile');
Route::post('admin/delfile', 'PhotosController@delfile')->name('admin.delfile');
Route::post('admin/delfilesql', 'PhotosController@delfilesql')->name('admin.delfilesql');