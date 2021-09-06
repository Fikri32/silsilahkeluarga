<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/','KeluargaController@index')->name('keluarga.index');
Route::get('/index','KeluargaController@data')->name('keluarga.data');
Route::post('/store','KeluargaController@store')->name('keluarga.store');
Route::get('/{id}/edit','KeluargaController@edit')->name('keluarga.edit');
Route::put('/{id}/update','KeluargaController@update')->name('keluarga.update');
Route::delete('/{id}/delete','KeluargaController@delete')->name('keluarga.delete');
