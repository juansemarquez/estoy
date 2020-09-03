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

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
Route::post('/', 'HomeController@store')->name('crear_comunicacion')->middleware('auth');
Auth::routes(['register' => false]);
//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::resource('cursos','CursoController')->middleware('auth');
Route::resource('docentes','DocentesController')->middleware('auth');
Route::resource('alumnos','AlumnoController')->middleware('auth');
Route::resource('comunicaciones','ComunicacionController')->middleware('auth');
Route::resource('posts','PostController')->middleware('auth');
Route::post('/comunicaciones_desde', 'ComunicacionController@listado_desde')->name('comunicaciones.listado')->middleware('auth');
