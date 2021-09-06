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
*/

Route::get('/','KeluargaController@index')->name('keluarga.index');
Route::get('/index','KeluargaController@data')->name('keluarga.data');
Route::post('/store','KeluargaController@store')->name('keluarga.store');
Route::get('/{id}/edit','KeluargaController@edit')->name('keluarga.edit');
Route::put('/{id}/update','KeluargaController@update')->name('keluarga.update');
Route::delete('/{id}/delete','KeluargaController@delete')->name('keluarga.delete');
