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

//Blade::setContentTags('<%', '%>');         // for variables and all things Blade
//Blade::setEscapedContentTags('<%%', '%%>');     // for escaped data

Route::get('/', function () {
    return view('welcome');
});

Route::any('index/add',['uses'=>'IndexController@add']);
Route::any('index/index', ['uses'=>'IndexController@index']);
Route::any('index/getdata', ['as'=>'getda','uses'=>'IndexController@getData']);
