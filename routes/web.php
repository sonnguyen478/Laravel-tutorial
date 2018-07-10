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
    return view('welcome');
});

Route::get('/hello', function () {
    //return view('welcome');
    return 'Hello World';
});

Route::get('/about',function(){
    return view('pages.about');
});

Route::get('/user/{id}',function($id){
    return 'This is user'.$id;
});

Route::get('/index','PagesController@index');

Route::get('/test','TestController@index');

Route::get('/about','PagesController@about');

Route::get('/services','PagesController@services');
