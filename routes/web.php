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

Route::get('/', 'TicketController@index')->middleware('sesion');

//Rutas para el inicio de sesion
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index');
Route::get('usuarios', 'UsuarioController@listarUsuarios');
Route::post('guardar_ticket', 'TicketController@nuevoTicket');
Route::post('usuarios','UsuarioController@create');


//Rutas cambiar contraseña por primera vez
Route::get('cambiar_password', 'CambiarPasswordController@cambiarPassword')->middleware('auth','sesionok');
Route::post('cambiar_password', 'CambiarPasswordController@password')->middleware('auth','sesionok');
Route::get('cambiar_pass', 'CambiarPasswordController@cancelarPassword')->middleware('auth','sesionok');
