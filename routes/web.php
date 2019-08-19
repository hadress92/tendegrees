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
Route::group(['middleware' => 'auth'], function(){
Route::get('tweet', 'TwitterController@createTweet')->name('twitter.createTweet');
Route::get('/delete/tweet/{id}', 'TwitterController@deleteTweet')->name('twitter.deleteTweet');
Route::post('tweet', 'TwitterController@sendTweet')->name('twitter.sendTweet');
Route::get('timeline', 'TwitterController@viewTweets')->name('twitter.timeline');
Route::get('/my/timeline', 'TwitterController@myTweets')->name('twitter.my_timeline');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
