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

Route::get('/', 'TicketController@index')->middleware('auth','sesion', 'admin');

//Rutas para el inicio de sesion
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::get('usuarios', 'UsuarioController@listarUsuarios')->middleware('auth','sesion', 'root');
Route::post('guardar_ticket', 'TicketController@nuevoTicket')->middleware('auth','sesion', 'admin');
Route::post('usuarios','UsuarioController@create')->middleware('auth','sesion', 'root');
Route::post('editar_usuario','UsuarioController@editar')->middleware('auth','sesion', 'root');


//Rutas cambiar contraseña por primera vez
Route::get('cambiar_password', 'CambiarPasswordController@cambiarPassword')->middleware('auth','sesionok');
Route::post('cambiar_password', 'CambiarPasswordController@password')->middleware('auth','sesionok');
Route::get('cambiar_pass', 'CambiarPasswordController@cancelarPassword')->middleware('auth','sesionok');

Route::get('consultartickets', 'TicketController@listarTickes')->middleware('auth','sesion');
Route::post('asignarTicket','TicketController@asignar')->middleware('auth','sesion', 'root');
Route::post('filtrar_tickets','TicketController@filtros')->middleware('auth','sesion');

Route::get('respuesta/{id}', 'RespuestasController@verRespuestas')->middleware('auth','sesion');




Route::get('empresas','EmpresaController@listarEmpresas')->middleware('auth','sesion', 'root');
Route::post('empresas','EmpresaController@create')->middleware('auth','sesion', 'root');

Route::post('saveResponse','RespuestasController@guardarRespuesta')->middleware('auth','sesion');

Route::get('consultarticketsna', 'TicketController@ticketsNoAsignados')->middleware('auth','sesion');
Route::post('guardarasignacion', 'TicketController@asignar')->middleware('auth','sesion', 'consultor');

Route::post('editarEmpresa', 'EmpresaController@editar')->middleware('auth','sesion', 'root');

Route::get('descarga/{parametro}', 'RespuestasController@descargar');

Route::post('editarRespuesta', 'RespuestasController@editar')->middleware('auth','sesion', 'root');