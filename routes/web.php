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


Auth::routes();
//Broadcast::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/main',  function (){
    return view('main');
});
Route::get('/offline' , function (){
    return view('debug');
});
Route::get('/test' , function (){
    return view('test');
});

Route::get('/entry', 'DominionAPIController@entry');

Route::get('/init_parent', 'DominionAPIController@initParent');
Route::get('/init_child', 'DominionAPIController@initChild');

Route::get('/start'      , 'DominionAPIController@start');

Route::get('/get_name' ,  'DominionAPIController@getName');

Route::get('/action_phase/exist', 'DominionAPIController@containActionCards');
Route::get('/action_phase/hands', 'DominionAPIController@showHands');
Route::get('/action_phase/is_action', 'DominionAPIController@isActionCards');
Route::get('/action_phase/action', 'DominionAPIController@action');

Route::get('/buy_phase/supplies' ,  'DominionAPIController@showSupplies');
Route::get('/buy_phase/estimate' ,  'DominionAPIController@estimate');
Route::get('/buy_phase/hands' ,  'DominionAPIController@showHands');
Route::get('/buy_phase/check' ,  'DominionAPIController@checkSelectedCards');
Route::get('/buy_phase/buy' ,  'DominionAPIController@buy');

Route::get('/clean' ,  'DominionAPIController@clean');
Route::get('/turn_end', 'DominionAPIController@exitTurn');
//Route::get('/lottery', 'DominionAPIController@lottery');

//for debug
Route::get('/init_playdata', 'DebugController@init');

Route::get('/debug/entry', 'DominionAPIController@entryOffline');
Route::get('/debug/id' ,     'DebugController@get_id');
Route::get('/debug/hand' ,   'DebugController@get_hand');
Route::get('/debug/deck',    'DebugController@get_deck');
Route::get('/debug/discard', 'DebugController@get_discard');
Route::get('/debug/playarea','DebugController@get_playarea');

Route::get('/debug/update_session1' ,  'DebugController@update_session1');
Route::get('/debug/update_session2' ,  'DebugController@update_session2');
Route::get('/debug/update_session3' ,  'DebugController@update_session3');

//Route::get('/get_card' ,  'DebugController@get_card');
//Route::get('/get_list' ,  'DebugController@get_list');


//+--------+----------+------------------------+------------------+------------------------------------------------------------------------+--------------+
//|        | GET|HEAD | /                      |                  | Closure                                                                | web          |
//|        | GET|HEAD | api/user               |                  | Closure                                                                | api,auth:api |
//|        | GET|HEAD | home                   | home             | App\Http\Controllers\HomeController@index                              | web,auth     |
//|        | GET|HEAD | login                  | login            | App\Http\Controllers\Auth\LoginController@showLoginForm                | web,guest    |
//|        | POST     | login                  |                  | App\Http\Controllers\Auth\LoginController@login                        | web,guest    |
//|        | POST     | logout                 | logout           | App\Http\Controllers\Auth\LoginController@logout                       | web          |
//|        | GET|HEAD | logout                 |                  | App\Http\Controllers\Auth\LoginController@logout                       | web          |
//|        | POST     | password/email         | password.email   | App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail  | web,guest    |
//|        | GET|HEAD | password/reset         | password.request | App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm | web,guest    |
//|        | POST     | password/reset         |                  | App\Http\Controllers\Auth\ResetPasswordController@reset                | web,guest    |
//|        | GET|HEAD | password/reset/{token} | password.reset   | App\Http\Controllers\Auth\ResetPasswordController@showResetForm        | web,guest    |
//|        | GET|HEAD | register               | register         | App\Http\Controllers\Auth\RegisterController@showRegistrationForm      | web,guest    |
//|        | POST     | register               |                  | App\Http\Controllers\Auth\RegisterController@register                  | web,guest    |
//+--------+----------+------------------------+------------------+------------------------------------------------------------------------+--------------+
