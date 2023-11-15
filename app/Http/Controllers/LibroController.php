<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Nacionalidad;
use App\Models\EstablecimientoTipo;
use App\Models\Registro;
use App\Models\Previo;
use App\Models\Empresa;
use App\Models\User;
use App\Models\it_ticket;
use App\Models\carrera;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Requisito;
use App\Models\Idioma;
use App\Models\libro;
use App\Models\Adjunto;
use App\Models\experiencia;
use App\Models\Empresas;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Jobs\previoPagoMail;
use Illuminate\Support\Facades\DB;

use App\Models\encuestas;

use PDF;
use QrCode;
use Uuid;

class LibroController extends Controller
{
    public function index()
    {
        $libro = Libro::all();
        return view('libro.index', compact('libros'));
    }

    public function create()
    {
        return view('libro.create');
    }


    public function getuserid(){
        return  auth()->id();
    }

    public function storeLibro(Request $request)
    {
        
        $dato = $request->except('token');
        $dato['periodo'] = date("Y");

        $cor_expedientes = Libro::where('periodo', '=', $dato['periodo'])->where('sededepartamental', '=', $dato['sededepartamental'])->count();
        $cor_expedientes = $cor_expedientes + 1;

        $expediente = 'LQ-'. $dato['sededepartamental'] . '-' . $cor_expedientes . '-' .$dato['periodo']. '-' . $dato['f63a'];

        /*$ext = ".svg";
        $qrCode  = Uuid::generate()->string;
        $qr_certificacion = 'pdf/' . $qrCode . '.pdf';
        $datosSolicitud['qr'] = $qr_certificacion;*/
        
        /*$record = libro::create($datosSolicitud);
        $record->save();
        $last_data = $record->id;*/
        //return $last_data;
        
        //foreach ($datosSolicitud as $dato) {
            $nuevoRegistro = new libro(); // Crea una nueva instancia de TuModelo
            
            // Asigna todos los valores de los campos uno por uno
            $nuevoRegistro->fecha_presentacion = $dato['fecha_presentacion'];
            $nuevoRegistro->nit = $dato['nit'];
            $nuevoRegistro->razonsocial = $dato['patente'];
            $nuevoRegistro->razonsocial = $dato['razonsocial'];
            $nuevoRegistro->direccion = $dato['direccion'];
            $nuevoRegistro->apartamento = $dato['apartamento'];
            $nuevoRegistro->zona = $dato['zona'];
            $nuevoRegistro->coloniabarrio = $dato['coloniabarrio'];
            $nuevoRegistro->municipalidad = $dato['municipalidad'];
            $nuevoRegistro->departamento = $dato['departamento'];
            $nuevoRegistro->municipio = $dato['municipio'];
            $nuevoRegistro->telefono = $dato['telefono'];
            $nuevoRegistro->fax = $dato['fax'];
            $nuevoRegistro->correoelectronico = $dato['correoelectronico'];
            $nuevoRegistro->nombreestablecimiento = $dato['nombreestablecimiento'];
            $nuevoRegistro->direccion2 = $dato['direccion2'];
            $nuevoRegistro->numero_casa = $dato['numero_casa'];
            $nuevoRegistro->zona_2 = $dato['zona_2'];
            $nuevoRegistro->coloniabarrio2 = $dato['coloniabarrio2'];
            $nuevoRegistro->municipio2 = $dato['municipio2'];
            $nuevoRegistro->departamento2 = $dato['departamento2'];
            $nuevoRegistro->periodo = $dato['periodo'];
            $nuevoRegistro->sededepartamental = $dato['sededepartamental'];
            $nuevoRegistro->tipoestablecimiento = $dato['tipoestablecimiento'];
            $nuevoRegistro->detalle = $dato['detalle'];
            $nuevoRegistro->f63a = $dato['f63a'];
            $nuevoRegistro->representantelegal = $dato['representantelegal'];   
            $nuevoRegistro->resolucion = $expediente;
            $nuevoRegistro->user_id = auth()->id();
            $nuevoRegistro->status = "ANALISIS";
            
            // Guarda el registro en la base de datos
            $nuevoRegistro->save();
            // Libro::where('id', '=', $nuevoRegistro->id)
            // ->update(['resolucion' => $expediente]);

       //}


        $last_data = $nuevoRegistro->id;
        return $last_data;
                
        //return redirect()->back()->with('success', 'Libro creado correctamente');        
    }

    public function show($id)
    {
        $libro = Libro::findOrFail($id);
        return view('libro.show', compact('libro'));
    }

    public function edit($id)
    {
        $libro = Libro::findOrFail($id);
        return view('libro.edit', compact('libro'));
    }

    public function update(Request $request, $id)
    {
        $libro = Libro::findOrFail($id);
      

        $libro->update($request->all());

        return redirect()->route('libros.index')->with('success', 'Libro actualizado correctamente');
    }

    public function destroy($id)
    {
        $libro = Libro::findOrFail($id);
        $libro->delete();

        return redirect()->route('libros.index')->with('success', 'Libro eliminado correctamente');
    }

    // Busquedas
    public function consultarLibros(Request $request){
        return libro::where('resolucion', 'like', '%' .$request->resolucion. '%')->get();
    }

    /*
        Consultar libros de quejas por nit, patente o razón social en el sistema antiguo.
    */
    public function busquedaRetroLibro(Request $request){
        // $query = null;
        // $request->input('nit')     ? $query = ['nit', '=', $request->input('nit')] : null;
        // $request->input('patente') ? $query = ['patente', '=', $request->input('patente')] : null;
        // $request->input('rSocial') ? $query = ['nempresa', 'LIKE', '%'.$request->input('rSocial').'%'] : null;

        $query = null;
        $request->nit       ? $query =  ['nit', '=', $request->nit] : null;
        $request->patente   ? $query =  ['patente', '=', $request->patente] : null;
        $request->rSocial   ? $query =  ['nempresa', 'LIKE', '%'.$request->rSocial.'%'] : null;

        if ($query) {
            $response = Empresas::where($query[0], $query[1], $query[2])->select(['resolucion AS libro','nit', 'patente', 'nempresa AS razonsocial','ncomercial AS empresa', 'id_status AS status', 'fecha'])->get();

            if (sizeof($response) > 0) {
                foreach ($response as &$lq) {
                    $bookStatus = Status::where('id_status', '=', $lq->status)->select(['evento'])->first();
    
                    $lq->status = $bookStatus->evento;
                }
            }
        } else {
            $response = response()->json(['message' => 'Parametros no especificados!'], 500);
        }
        
        return $response;
    }

    public function obtenerCantLibros(Request $request) {
        return $response = libro::where('periodo', '=', $request->periodo)->select(DB::raw('sededepartamental AS sede, MONTH(fecha_presentacion) AS mes, COUNT(*) AS cantidad'))
        ->groupBy('sede', 'mes')->orderBy('mes', 'ASC')->get();
    }

    // Expedientes
    public function listadoExpedientesLq(Request $request)
    {
        return Libro::where('user_id', auth()->id())->orderBy('id', 'DESC')->get();
    }

    // Listar sedes por usuario
    public function colocarSede(Request $request){

        $usuario = User::where('id', '=', auth()->id())->first();

        return Departamento::where('id', $usuario->sede)->get();
    }

    // Listar tipo establecimiento
    public function colocarEtb(){
        return EstablecimientoTipo::all();
    }

    // Listar periodos por registro
    public function colocarPeriodos(){
        return libro::select('periodo')->groupBy('periodo')
        ->orderBy('periodo', 'desc')
        ->get();
    }
}

