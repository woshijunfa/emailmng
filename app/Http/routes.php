<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

#主页介绍相关
// Route::get('/', 'CopyController@index');

// //登录注册相关
// Route::get('/users/sign_in', "UserController@login");
// Route::get('/users/sign_up', 'CopyController@common');
// Route::post('/register',"UserController@regiestPost");
// Route::post('/login',"UserController@loginPost");
// Route::post('/setLoginPass',"UserController@setLoginPass");
// Route::post('/resetPassEmail',"UserController@resetPassEmail");
// Route::get('/logout',"UserController@logout");


// Route::get('/test','TestController@test');

// //auto-generate-route
// Route::group(['middleware'=>'auth'], function () {

// });


Route::get('/', 'EmailController@index');
Route::post('/email/addpici',"EmailController@addpici");

Route::get('/content', 'ContentController@index');
Route::get('/content/add', 'ContentController@add');
Route::get('/content/show/{id}', 'ContentController@show');
Route::post('/content/addpost',"ContentController@addpost");

//发送管理
Route::get('/sendlog', 'EmailController@sendlog');
Route::post('/email/pici/beginsend',"EmailController@beginSend");
Route::post('/email/pici/endsend',"EmailController@endSend");

