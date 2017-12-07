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

//Rutas para el inicio de sesion
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');


//Rutas de empresas
Route::get('empresas','EmpresaController@listarEmpresas')->middleware('auth','sesion', 'root');
Route::post('empresas','EmpresaController@create')->middleware('auth','sesion', 'root');
Route::post('editarEmpresa', 'EmpresaController@editar')->middleware('auth','sesion', 'root');


///Rutas de usuarios
Route::get('usuarios', 'UsuarioController@listarUsuarios')->middleware('auth','sesion', 'root');
Route::post('usuarios','UsuarioController@create')->middleware('auth','sesion', 'root');
Route::post('editar_usuario','UsuarioController@editar')->middleware('auth','sesion', 'root');


//Rutas cambiar contraseña por primera vez
Route::get('cambiar_password', 'CambiarPasswordController@cambiarPassword')->middleware('auth','sesionok');
Route::post('cambiar_password', 'CambiarPasswordController@password')->middleware('auth','sesionok');
Route::get('cambiar_pass', 'CambiarPasswordController@cancelarPassword')->middleware('auth','sesionok');


//Rutas de tickets
Route::get('/','TicketController@resumen')->middleware('auth','sesion','rootconsultor');
Route::get('filtro_resumen/{fecha}','TicketController@filtro_resumen')->middleware('auth','sesion','rootconsultor');
Route::get('/crear_ticket', 'TicketController@index')->middleware('auth','sesion', 'adminroot');
Route::post('guardar_ticket', 'TicketController@nuevoTicket')->middleware('auth','sesion', 'adminroot');
Route::get('consultartickets', 'TicketController@listarTickes')->middleware('auth','sesion');
Route::get('filtrar_tickets','TicketController@filtros')->middleware('auth','sesion');
Route::get('filtrar_tickets2','TicketController@filtros2')->middleware('auth','sesion', 'root');
Route::post('asignarTicket','TicketController@asignar')->middleware('auth','sesion', 'rootconsultor');
Route::get('reabrir_ticket/{id}','TicketController@reabrir')->middleware('auth','sesion','root');
Route::get('tickets_reasignar','TicketController@lista_reasignar')->middleware('auth','sesion','rootconsultor');
Route::get('consultarticketsna', 'TicketController@ticketsNoAsignados')->middleware('auth','sesion', 'rootconsultor');
Route::post('guardarasignacion', 'TicketController@asignar')->middleware('auth','sesion', 'rootconsultor');
Route::get('misTickets', 'TicketController@misTickets')->middleware('auth','sesion', 'root');


///Rutas de respuestas
Route::get('respuesta/{id}', 'RespuestasController@verRespuestas')->middleware('auth','sesion');
Route::post('saveResponse','RespuestasController@guardarRespuesta')->middleware('auth','sesion');
Route::get('descarga/{parametro}', 'RespuestasController@descargar');
Route::post('editarRespuesta', 'RespuestasController@editar')->middleware('auth','sesion', 'consultor');


///Rutas de visitas
Route::get('formatoVisita', 'VisitasController@index')->middleware('auth','sesion', 'rootconsultor');
Route::post('guardarVisita', 'VisitasController@guardarVisita')->middleware('auth','sesion', 'rootconsultor');
Route::get('listarvisitas', 'VisitasController@listado')->middleware('auth','sesion', 'rootconsultor');
Route::get('visitaPdf/{id}', 'VisitasController@verPdf')->middleware('auth','sesion', 'rootconsultor');
Route::get('evidenciaVisita/{id}', 'VisitasController@evidencia')->middleware('auth','sesion', 'rootconsultor');
Route::post('guardarEvidenciaVisita', 'VisitasController@guardarEvidencia')->middleware('auth','sesion', 'rootconsultor');
Route::get('descargar/{parametro}', 'VisitasController@descargar')->middleware('auth','sesion', 'rootconsultor');
Route::get('listarvisitasgrl', 'VisitasController@listGeneral')->middleware('auth','sesion', 'root');



//Rutas para contratos
Route::get('/contratos','ContratosController@lista')->middleware('auth','sesion','root');
Route::get('/crear_contrato','ContratosController@crear')->middleware('auth','sesion','root');
Route::get('/modulos','ContratosController@modulos')->middleware('auth','sesion','rootconsultor');
Route::post('/guardar_modulo','ContratosController@guardar_modulo')->middleware('auth','sesion','rootconsultor');
Route::get('/descargar_manual/{file}','ContratosController@descargar')->middleware('auth','sesion','rootconsultor');
Route::get('/filtrarm/{nombre}','ContratosController@filtrarModulos')->middleware('auth','sesion','rootconsultor');
Route::get('/filtrarc/','ContratosController@filtrarContratos')->middleware('auth','sesion','rootconsultor');

Route::post('/guardarContrato', 'ContratosController@guardarContrato');
Route::post('/editarHoras', 'ContratosController@editarHoras');