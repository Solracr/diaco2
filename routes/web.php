<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\RequisitoController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\PrevioController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\NivelacademicoController;
use App\Http\Controllers\OcupacionController;
use App\Http\Controllers\FirmaController;
use App\Http\Controllers\MigracionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PesaController;
use App\Http\Controllers\Formulario63AController;


Route::get('/', function () {
    return redirect('/home');
});

Route::get('logout', [  App\Http\Controllers\Auth\LoginController::class, 'logout']);
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {});


Route::get('/users/viewx',[UserController::class,'index']);
Route::get('/users/index',[UserController::class,'index'])->name('users.index')->middleware('auth');
Route::get('/users/inactivar/{user}',[UserController::class,'inactivar'])->name('users.inactivar')->middleware('auth');
Route::get('/users/activar/{user}',[UserController::class,'activar'])->name('users.activar')->middleware('auth');
Route::get('/users/create',[UserController::class,'create'])->name('users.create')->middleware('auth');
Route::get('/users/show/{id}',[UserController::class,'show'])->name('users.show')->middleware('auth');
Route::post('/users/store',[UserController::class,'store'])->name('users.store')->middleware('auth');
Route::patch('/users/update/{user}',[UserController::class,'update'])->name('users.update')->middleware('auth');
Route::get('/users/edit/{id}',[UserController::class,'edit'])->name('users.edit')->middleware('auth');
Route::delete('/users/destroy/{id}',[UserController::class,'destroy'])->name('users.destroy')->middleware('auth');
Route::delete('/users/delete/{id}',[UserController::class,'destroy'])->name('users.delete')->middleware('auth');

Route::get('/migracion/buscar',[MigracionController::class,'index'])->middleware('auth');
Route::post('/migracion/procesar',[MigracionController::class,'buscar'])->name('migracion.buscar')->middleware('auth');

Route::get('/dashboard/main',[DashboardController::class,'index'])->name('dashboard')->middleware('auth');

Route::get('/registro', function () {    
    return view('users.registro');
})->name('users.registro');

//Route::get('/usuarios', [UserController::class,'index']);
//Route::get('/roles', [RoleController::class,'index']);

Route::get('/certificaciones', function () {return view('certificaciones.certificacion');});
Route::post('/certificaciones/consultar',[SolicitudController::class,'certificaciones']);
Route::get('/empresa/solicitud', function () {return view('empresa.grid_listado_empresa');})->name('empresa.grid_listado_empresa')->middleware('auth');
Route::get('expedientes', function () {return view('empresa.grid_expedientes_empresa');})->name('empresa.grid_expedientes_empresa2')->middleware('auth');


//Route::get('/expedientes/grid', function ($selector) {return view('solicitud.grid_expedientes',compact('selector'));})->name('grid_expedientes')->middleware('auth');
Route::get('/empresa/expedientes', function () {return view('empresa.grid_expedientes_empresa');})->name('empresa.grid_expedientes_empresa')->middleware('auth');
Route::get('/empresa/webservice', function () {return view('empresa.webservice');})->name('empresa.webservice')->middleware('auth');
Route::get('/empresa/consultarnit', function () {return view('empresa.nit');})->name('empresa.nit')->middleware('auth');

//contrato de adhesion

Route::get('/encuesta', function () {    
    return view('solicitud.encuesta_con');
})->name('encuesta_con');

Route::post('/empresa/txt_mail',[MailController::class,'txt_mail'])->middleware('auth');
Route::post('/empresa/encuesta_con',[EncuestaController::class,'encuesta_con']);


Route::get('/empresa/ticket_grid', function () {return view('solicitud.grid_ticket');})->name('solicitud.grid_ticket')->middleware('auth');
Route::get('/empresa/grid_ticket_report', function () {return view('solicitud.grid_ticket_report');})->name('solicitud.grid_ticket_report')->middleware('auth');
Route::post('/listado_reporte_ticket',[TicketController::class,'listado_reporte_ticket'])->middleware('auth');


Route::get('/ticket_validacion/{client_id}/{tipo_ruta}',function ($client_id, $tipo_ruta){    
    return view('solicitud.fileu',
    [
        'client_id' => $client_id,
        'tipo_ruta' => $tipo_ruta
    ]);
})->name('solicitud.fileu');

Route::post('/contratoUpload', [SolicitudController::class, 'contratoUpload'])->name('contratos.file')->middleware('auth');


Route::post('/ticketok/{client_id}', [TicketController::class, 'conformidadOk'])->name('ticket.conformidad');
Route::post('/ticketfail/{client_id}', [TicketController::class, 'conformidadFail'])->name('ticket.no_conformidad');


Route::post('/ticket/generarBoleta',[TicketController::class,'generarBoleta'])->middleware('auth');

Route::get('/it/ticket', function () {return view('solicitud.ticket');})->name('solicitud.ticket');

//==============================================================================================================================================*/
//contratos de adhesion
Route::get('/empresa/form_solicitud', function () {return view('solicitud.contrato_solicitud');})->name('solicitud.contrato_solicitud')->middleware('auth');
Route::get('/expedientes/grid', function () {return view('solicitud.grid_expedientes');})->name('solicitud.grid_expedientes')->middleware('auth');
//==============================================================================================================================================*/



//formulario de ingreso de datos para libro de quejas
//*********************************************************************************************************************************************** */
Route::get('/empresa/form_solicitud_libro', function () {return view('solicitud.libro_solicitud');})->name('solicitud.form_solicitud_libro')->middleware('auth');
Route::get('/expedientes/grid_libro', function () {return view('solicitud.grid_expedientes_libros');})->name('solicitud.grid_expedientes_libros')->middleware('auth');

Route::get('/empresa/rep_libro_fechas', function () {return view('solicitud.rep_libro_fechas');})->name('solicitud.rep_libro_fechas')->middleware('auth');
Route::get('/libro/storeLibro', [LibroController::class,'storeLibro'])->middleware('auth');
//==============================================================================================================================================*/
Route::get('/libro/userid', [LibroController::class,'getuserid'])->middleware('auth');
//==============================================================================================================================================*/

//  Contratos
//      Componentes
//          Colaboradores
Route::get('/contrato/rep_contrato_fechas', function () {return view('solicitud.rep_contrato_fechas');})->name('solicitud.rep_contrato_fechas')->middleware('auth');
//      Funciones
//          Colaboradores
Route::get('/contrato/colocar/periodo',[SolicitudController::class, 'colocarPeriodosCa'])->middleware('auth');
Route::post('/contrato/reporte',[SolicitudController::class, 'obtenerCantCa'])->middleware('auth');


//  Pesas
//      Componentes
//          Solicitantes
Route::get('/empresa/form_solicitud_pesas', function () {return view('solicitud.pesas_solicitud');})->name('solicitud.form_solicitud_pesas')->middleware('auth');
//          Colaboradores
Route::get('/empresa/grid_pesas', function () {return view('solicitud.grid_expedientes_pesas');})->name('solicitud.grid_expedientes_pesas')->middleware('auth');
Route::get('/empresa/rep_pesas_fechas', function () {return view('solicitud.rep_pesas_fechas');})->name('solicitud.rep_pesas_fechas')->middleware('auth');
Route::get('/analista/visor/pesas', function () {return view('analista.visorExpedientesPesas');})->name('analista.visorExpedientesPesas')->middleware('auth'); // Blade
//      Funciones
//          Solicitante
Route::post('/pesa/storePesa', [PesaController::class,'storePesa'])->middleware('auth');
Route::post('/pesa/cargar/archivo', [PesaController::class,'cargarArchivoImp'])->middleware('auth');
Route::post('/pesa/actualizar/boleta', [PesaController::class,'boletaUpdateImp'])->middleware('auth');
//          Colaboradores
Route::post('/pesa/listar/expedientes', [PesaController::class,'listadoExpedientesImp'])->middleware('auth');
Route::post('/analista/listar/requisitos/pesas',[PesaController::class, 'listarRequisitosExpImp'])->middleware('auth');
Route::get('/pesa/colocar/periodo',[PesaController::class, 'colocarPeriodosImp'])->middleware('auth');
Route::post('/pesa/reporte',[PesaController::class, 'obtenerCantImp'])->middleware('auth');

//  Libros
//      Componentes
Route::get('/libro/rep_consultar', function () {return view('solicitud.rep_libro_consulta');})->name('solicitud.rep_libro_consulta')->middleware('auth');
Route::get('/libro/rep_consultar_old', function () {return view('solicitud.rep_libro_consulta_retro');})->name('solicitud.rep_libro_consulta_retro')->middleware('auth');
Route::get('/libro/rep_periodo', function () {return view('solicitud.rep_libro_periodo');})->name('solicitud.rep_libro_periodo')->middleware('auth');
//      Funciones
//          Colaboradores
Route::post('/libro/consultar/libros', [LibroController::class,'consultarLibros'])->middleware('auth');
Route::post('/libro/listar/expedientes', [LibroController::class,'listadoExpedientesLq'])->middleware('auth');
Route::get('/libro/colocar/sede', [LibroController::class,'colocarSede'])->middleware('auth');
Route::get('/libro/colocar/tipo_establecimiento', [LibroController::class,'colocarEtb'])->middleware('auth');
Route::get('/libro/colocar/periodo', [LibroController::class,'colocarPeriodos'])->middleware('auth');
Route::post('/libro/reportes', [LibroController::class,'obtenerCantLibros'])->middleware('auth');
Route::post('/libro/consultar/libros_old', [LibroController::class,'busquedaRetroLibro'])->middleware('auth');

/*CERTIFICACIONES*/
// routes/api.php
Route::get('/certificaciones/f63a_solicitud', function () {return view('solicitud.f63a_solicitud');})->name('solicitud.f63a_solicitud')->middleware('auth');
Route::get('/certificaciones/grid_f63a_solicitud', function () {return view('solicitud.grid_f63a_solicitud');})->name('solicitud.grid_f63a_solicitud')->middleware('auth');
Route::post('/f63a/store', [Formulario63AController::class,'store'])->middleware('auth');
<<<<<<< HEAD
=======
Route::get('/certificaciones/grid_f63a_solicitud', function () {return view('solicitud.grid_f63a_solicitud');})->name('solicitud.grid_f63a_solicitud')->middleware('auth');
>>>>>>> d0850ca8e03bcd9df297446a98e3d52681dae4e3
Route::post('/f63a/get', [Formulario63AController::class,'get'])->middleware('auth');

//Route::resource('formulario63A', 'Formulario63AController');

//=========================================================================================//
Route::get('/empresa/actualizar', function () {return view('solicitud.form_solicitud_empresa_actualizar');})->name('solicitud.form_solicitud_empresa_actualizar')->middleware('auth');
Route::get('/requisitos', function () {return view('solicitud.form_requisitos_empresa');})->name('solicitud.form_requisitos_empresa')->middleware('auth');
Route::get('/gridBitacora', function () {return view('bitacora.gridBitacora');})->name('bitacora.gridBitacora')->middleware('auth');
Route::get('/requisitos/form_upload_file', function () {return view('adjuntos.form_upload_file');})->name('adjuntos.form_upload_file')->middleware('auth');
Route::get('/requisitos/form_upload_file_contrato', function () {return view('adjuntos.form_upload_file_contrato');})->name('adjuntos.form_upload_file_contrato')->middleware('auth');
Route::get('/requisitos/form_upload_file_pesa', function () {return view('adjuntos.form_upload_file_pesa');})->name('adjuntos.form_upload_file_pesa')->middleware('auth');

Route::post('empresa/solicitud/store',[SolicitudController::class,'store'])->middleware('auth');
Route::post('empresa/solicitud/update',[SolicitudController::class,'update'])->middleware('auth');
Route::get('empresa/solicitud/nacionalidades',[SolicitudController::class,'nacionalidades'])->middleware('auth');
Route::get('empresa/solicitud/listadoAnalistas',[SolicitudController::class,'listadoAnalistas'])->middleware('auth');
Route::get('empresa/solicitud/departamentos',[SolicitudController::class,'departamentos'])->middleware('auth');
Route::get('/solicitud/exp',[SolicitudController::class,'experiencia'])->middleware('auth');
Route::put('empresa/solicitud/municipios',[SolicitudController::class,'municipios'])->middleware('auth');
Route::put('/solicitud/municipios',[SolicitudController::class,'municipios'])->middleware('auth');
Route::get('empresa/solicitud/idiomas',[SolicitudController::class,'idiomas'])->middleware('auth');
Route::post('/solicitud/requisitos',[SolicitudController::class,'requisitos'])->middleware('auth');
Route::get('/empresa/listadoEmpresas',[EmpresaController::class, 'listadoEmpresas'])->middleware('auth');
// Boleta
Route::post('empresa/solicitud/boletaPago',[SolicitudController::class,'boletaUpdate'])->middleware('auth');
Route::post('empresa/solicitud/cargar/boletaPago', [SolicitudController::class,'cargarBoleta'])->middleware('auth');
// Archivos

/*FIRMA ELECTRONICA*/
Route::post('/firma/rechazar',[FirmaController::class,'rechazar'])->middleware('auth');  
Route::post('/firma/firmar',[FirmaController::class,'firmar'])->middleware('auth');  
Route::post('/firma/closeFile',[FirmaController::class,'closeFile'])->middleware('auth');  
Route::post('/firma/restore',[FirmaController::class,'restaurarFirma'])->middleware('auth');  
Route::post('/firma/testMail',[FirmaController::class,'testMail'])->middleware('auth');
// API
Route::post('/firmante/visualizar/documento/',[FirmaController::class,'visualizarDocFirmado'])->middleware('auth');
Route::post('/firmante/cargar/documento/',[FirmaController::class,'actualizarDocFirmado'])->middleware('auth');


//Route::get('/empresa/listadoSolicitudesEmpresa',[SolicitudController::class, 'listadoSolicitudesEmpresa'])->middleware('auth');

Route::get('/listadoSolicitudesEmpresa',[SolicitudController::class, 'listadoSolicitudesEmpresa'])->middleware('auth');
Route::put('/obtenerSolicitudesEmpresa',[SolicitudController::class, 'obtenerSolicitudesEmpresa'])->middleware('auth');
Route::post('/listado',[SolicitudController::class, 'listadoExpedientes'])->middleware('auth');
Route::post('/listado_ticket',[SolicitudController::class, 'listado_ticket'])->middleware('auth');
Route::post('/listado_encuestas',[SolicitudController::class, 'listado_encuestas'])->middleware('auth');
Route::post('/listadoAnalista',[SolicitudController::class, 'listadoAnalista'])->middleware('auth');
Route::post('/listadoAnalistaDashboard',[SolicitudController::class, 'listadoAnalistaDashboard'])->middleware('auth');
Route::get('empresa/webservice/consultarNit',[EmpresaController::class, 'webserviceSat'])->middleware('auth');
Route::post('/ConsultarRepresentante',[EmpresaController::class, 'consultarRepresentante'])->middleware('auth');
Route::get('empresa/consultarNit',[EmpresaController::class, 'webserviceSat'])->middleware('auth');
Route::post('empresa/registrarEmpresa',[EmpresaController::class, 'registrarEmpresa'])->middleware('auth');
Route::post('empresa/actualizarEmpresa',[EmpresaController::class, 'actualizarEmpresa'])->middleware('auth');
Route::post('empresa/consultarEmpresa',[EmpresaController::class, 'consultarEmpresa'])->middleware('auth');




Route::post('/eventos/obtenerListado',[RegistroController::class,'obtenerListado'])->middleware('auth');
Route::post('/registro/obtenerBitacora',[RegistroController::class,'obtenerBitacora'])->middleware('auth');
Route::post('/registro/obtenerUltimo',[RegistroController::class,'obtenerUltimo'])->middleware('auth');
Route::post('/registro/actualizar',[RegistroController::class,'actualizar'])->middleware('auth');

Route::post('/registro/generarBoleta',[SolicitudController::class,'generarBoleta'])->middleware('auth');




Route::get('/contrato_adhesion/{tipo_ruta}',function ($tipo_ruta){    
    return view('solicitud.uploadcontrato',
    [
        //'id' => $id
        //,
        'tipo_ruta' => $tipo_ruta
    ]);
})->name('solicitud.uploadcontrato')->middleware('auth');
//zlkjxcvkla4f54




Route::get('/contrato_adhesion/{tipo_ruta}',function ($tipo_ruta){    
    return view('solicitud.uploadcontrato',
    [
        //'id' => $id
        //,
        'tipo_ruta' => $tipo_ruta
    ]);
})->name('solicitud.uploadcontrato')->middleware('auth');
//zlkjxcvkla4f54


Route::post('/cargar/archivo',[RequisitoController::class,'uploadFile'])->middleware('auth');
Route::post('/cargar/archivo_contratos',[RequisitoController::class,'uploadFile_contratos'])->middleware('auth');
Route::post('/cargar/eliminar',[RequisitoController::class,'eliminar'])->middleware('auth');
Route::post('/cargar/uploadPago',[RequisitoController::class,'uploadPago'])->middleware('auth');
Route::get('requisito/files',[RequisitoController::class,'index'])->middleware('auth');
Route::post('requisito/upload',[RequisitoController::class,'upload'])->middleware('auth');
// Archivos
//      Cargar
Route::post('/api/cargar/archivo', [RequisitoController::class, 'cargarArchivoContrato'])->middleware('auth');

Route::post('/CarreraController/busquedaBolsa',[CarreraController::class,'busquedaBolsa'])->middleware('auth');
Route::post('/CarreraController/indexObtenerListado',[CarreraController::class,'indexObtenerListado'])->middleware('auth');
Route::get('/NivelacademicoController/index',[NivelacademicoController::class,'index'])->middleware('auth');
Route::get('/OcupacionController/index',[OcupacionController::class,'index'])->middleware('auth');

Route::post('/previo/actualizar',[PrevioController::class,'actualizar'])->middleware('auth');


Route::get('/analista/dashboard', function () {return view('analista.dashboard');})->name('analista.dashboard')->middleware('auth');
Route::get('/analista/mesadetrabajo', function () {return view('analista.mesatrabajo');})->name('analista.mesatrabajo')->middleware('auth');
Route::get('/analista/visorexpediente', function () {return view('analista.visorExpedientes');})->name('analista.visorExpedientes')->middleware('auth');
Route::get('/analista/listadoSolicitudesEmpresa',[SolicitudController::class, 'listadoSolicitudesEmpresa'])->middleware('auth');
Route::post('/analista/cargarRequisitosExpediente',[RequisitoController::class, 'cargarRequisitosExpediente'])->middleware('auth');
// Archivos
//      Cargar
Route::post('/analista/cargar/requisitos/',[RequisitoController::class, 'cargarReqExpApi'])->middleware('auth');
//      Descargar/Vizualizar
Route::post('/analista/visualizar/requisitos/',[RequisitoController::class, 'visualizarDocApi'])->middleware('auth');

///empresa/ticket_add
Route::post('/empresa/ticket_add',[TicketController::class,'ticket_add']);
Route::post('/ticket/dictamen',[TicketController::class,'dictamen'])->middleware('auth');


Route::get('/empresa/sgc_grid', function () {return view('solicitud.grid_encuestas');})->name('solicitud.grid_encuestas')->middleware('auth');



