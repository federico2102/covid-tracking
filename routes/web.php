<?php

use App\Events\Notificacion;
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
Route::get('/concurrio/{locacionId}',"ConcurrioController@index");
Route::post('/concurrio/store/{locacionId}/{userId}',"ConcurrioController@store");
Route::get('/galeria/{id}',"LocacionController@getImages");
Route::get('/informarcontagio',"ContagiosController@informarContagio");
Route::get('/informartest',"ContagiosController@testNegativo");
Route::get('/admin', "AdminPanel@index");
Route::get('notificacion', function() {
    Auth::user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('leida');



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    event(new App\Events\Notificacion(Auth::user()->name));
    return view('dashboard');
})->name('dashboard');
