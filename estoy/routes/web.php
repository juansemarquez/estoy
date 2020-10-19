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
Route::post('/crear_comunicacion', 'ComunicacionController@store2')->name('crear_comunicacion')->middleware('auth');
Route::get('/crear_grupal', 'ComunicacionController@create_grupal')->name('crear_grupal')->middleware('auth');
Route::post('/store_grupal', 'ComunicacionController@store_grupal')->name('store_grupal')->middleware('auth');
Auth::routes(['register' => false]);
//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::resource('cursos','CursoController')->middleware('auth');
Route::resource('docentes','DocentesController')->middleware('auth');
Route::resource('alumnos','AlumnoController')->middleware('auth');
Route::resource('comunicaciones','ComunicacionController')->middleware('auth');
Route::post('posts/borrar_adjunto/{id_adjunto}','PostController@borrar_adjunto')->name('borrar_adjunto')->middleware('auth');
Route::resource('posts','PostController')->middleware('auth');
Route::post('/comunicaciones_desde', 'ComunicacionController@listado_desde')->name('comunicaciones.listado')->middleware('auth');
Route::post('/lecturas', 'LecturaController@store')->name('lecturas.store')->middleware('auth');
Route::delete('/lecturas', 'LecturaController@destroy')->name('lecturas.delete')->middleware('auth');
Route::post('/comentarios', 'ComentarioController@store')
                        ->name('comentario.store')->middleware('auth');
Route::delete('/comentarios', 'ComentarioController@destroy')
    ->name('comentario.destroy')->middleware('auth');
