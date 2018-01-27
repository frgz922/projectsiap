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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
/********* Rutas Categorías *******/
Route::match(['get', 'post'],'/crearCategoria', 'CategoriaController@crearCategoria')->name('crearCategoria');
Route::match(['get', 'post'],'/consultarCategorias', 'CategoriaController@consultarCategorias')->name('consultarCategorias');
Route::match(['get', 'post'],'/eliminarCategoria', 'CategoriaController@eliminarCategoria')->name('eliminarCategoria');
/********* Fin Rutas Categorías *******/

/********* Rutas Proyectos *******/
Route::match(['get', 'post'],'/crearProyecto', 'ProyectoController@crearProyecto')->name('crearProyecto');
Route::match(['get', 'post'],'/editarProyecto', 'ProyectoController@editarProyecto')->name('editarProyecto');
Route::match(['get', 'post'],'/eliminarProyecto', 'ProyectoController@eliminarProyecto')->name('eliminarProyecto');
Route::match(['get', 'post'],'/enviarProyectoEmail', 'ProyectoController@enviarProyectoEmail')->name('enviarProyectoEmail');
Route::match(['get', 'post'],'/consultarProyectos', 'ProyectoController@consultarProyectos')->name('consultarProyectos');
Route::match(['get', 'post'],'/consultarProyectoPorID', 'ProyectoController@consultarProyectoPorID')->name('consultarProyectoPorID');
Route::match(['get', 'post'],'/filterProyectos', 'ProyectoController@filterProyectos')->name('filterProyectos');
/********* Rutas Proyectos *******/


Route::get('/prueba', 'CategoriaController@pruebas')->name('pruebas');

/*Route::get('register', ['middleware' => ['auth', 'admin'], function() {
}]);*/