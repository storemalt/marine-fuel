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
Route::get('/home', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home/occurrence', 'HomeController@index')->name('home.occurrence');
Route::get('/home/unique-string', 'HomeController@uniqueString')->name('home.unique.string');
Route::get('/home/pinpoint-map', 'HomeController@pinPointMapping')->name('home.pinpoint.map');
Route::post('/home/store/occurrence', 'HomeController@occurrence')->name('home.store.occurrence');
Route::post('/home/store/unique', 'HomeController@unique')->name('home.store.unique');
Route::post('/home/store/location', 'HomeController@storeLocation')->name('home.store.location');
