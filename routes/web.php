<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/',"HomeScreen@index");
Route::get('/home', "MainController@index");
Route::get('/location', "LocacionController@index");
Route::get('/edit/{id}',"LocacionController@edit");
Route::get('/show/{id}',"LocacionController@show");
Route::get('/create',"LocacionController@create");
Route::post('/store',"LocacionController@store");
Route::post('/update/{id}',"LocacionController@update");
Route::get('/map/{Geolocalizacion}', "MapController@show");
Route::post('/concurrio/Store/{locacionId}/{userId}',"ConcurrioController@store");
Route::get('/concurrio/{locacionId}',"ConcurrioController@index");



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
