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

Route::get('/', 'Auth\LoginController@showLoginForm');
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('login');

Route::get('logout', 'Auth\LoginController@logout');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/debug', function (){
    return view('debug');
})->middleware('auth');

Route::get('/entry',  function (){
    return view('entry');
})->middleware('auth');

Route::get('/main',  function (){
    return view('main');
})->middleware('auth');


Route::group(['middleware' => ['auth']], function () {
    Route::post('/games', 'GameController@create');
    Route::post('/users', 'UserController@create');
    Route::get('/turns/player', 'TurnController@show');
    Route::put('/turns'       , 'TurnController@edit');
});




Route::get('/init_parent', 'GameController@initParent');
Route::get('/init_child', 'GameController@initChild');

Route::get('/start'      , 'GameController@start');

Route::get('/get_name' ,  'GameController@getName');
Route::get('/dummy' ,  'GameController@dummy');


Route::get('/hands',     'GameController@showHands');
Route::get('/supplies' , 'GameController@showSupplies');
Route::get('/playarea' , 'GameController@showPlayArea');
Route::get('/trashes',  'GameController@showTrashes');
Route::get('/hands_and_playarea','GameController@getHandsAndPlayArea');


Route::get('/action_phase/exist', 'GameController@containActionCards');
Route::get('/action_phase/is_action', 'GameController@isActionCards');
Route::get('/action_phase/action', 'GameController@action');

Route::get('/buy_phase/estimate' ,  'GameController@estimate');
Route::get('/buy_phase/hands' ,  'GameController@showHands');
Route::get('/buy_phase/check' ,  'GameController@checkSelectedCards');
Route::get('/buy_phase/buy' ,  'GameController@buy');

Route::get('/clean' ,  'GameController@clean');

//for debug
Route::get('/init_playdata', 'DebugController@init');

Route::get('/debug/entry', 'GameController@entryOffline');
Route::get('/debug/id' ,     'DebugController@get_id');
Route::get('/debug/hand' ,   'DebugController@get_hand');
Route::get('/debug/deck',    'DebugController@get_deck');
Route::get('/debug/discard', 'DebugController@get_discard');
Route::get('/debug/playarea','DebugController@get_playarea');
Route::get('/debug/coin','DebugController@get_coin');
Route::get('/debug/action_counts','DebugController@get_action_counts');
Route::get('/debug/buy_counts'   ,'DebugController@get_buy_counts');




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
