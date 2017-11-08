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

Route::get('/', 'TicketController@index')->middleware('auth','sesion');

//Rutas para el inicio de sesion
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::get('usuarios', 'UsuarioController@listarUsuarios')->middleware('auth','sesion');
Route::post('guardar_ticket', 'TicketController@nuevoTicket')->middleware('auth','sesion');
Route::post('usuarios','UsuarioController@create')->middleware('auth','sesion');


//Rutas cambiar contraseña por primera vez
Route::get('cambiar_password', 'CambiarPasswordController@cambiarPassword')->middleware('auth','sesionok');
Route::post('cambiar_password', 'CambiarPasswordController@password')->middleware('auth','sesionok');
Route::get('cambiar_pass', 'CambiarPasswordController@cancelarPassword')->middleware('auth','sesionok');

Route::get('consultartickets', 'TicketController@listarTickes')->middleware('auth','sesion');

Route::get('empresas','EmpresaController@listarEmpresas')->middleware('auth','sesion');
Route::post('empresas','EmpresaController@create')->middleware('auth','sesion');