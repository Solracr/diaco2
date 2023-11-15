<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Nacionalidad;
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
use App\Models\Pesa;
use App\Models\Boleta;
use App\Models\Adjunto;
use App\Models\experiencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Jobs\previoPagoMail;
use Illuminate\Support\Facades\DB;
// Consumir API
use Illuminate\Support\Facades\Http;

use App\Models\encuestas;

use PDF;
use QrCode;
use Uuid;
use Mail;


class PesaController extends Controller
{
    public function listarRequisitosExpImp(Request $request)
    {       
        $response = Http::get('http://localhost:3001/api/doc/listar/archivos?expediente='.$request->expediente);

        return $response;               
    }

    public function listadoExpedientesImp(Request $selector)
    {
        $datosSolicitud = $selector;
        // switch ($datosSolicitud['action']) {
        //     case "C":
        //         return Solicitud::where('user_id', auth()->id())
        //             ->where('tipo2', '=', 'A')
        //             ->orWhere('tipo2', '=', 'C')
        //             ->orderBy('id', 'DESC')->get();
        //         break;
        //     case "R":
        //         return Solicitud::where('user_id', auth()->id())
        //             ->where('tipo2', '=', 'G')
        //             ->orWhere('tipo2', '=', 'B')
        //             ->orderBy('id', 'DESC')->get();
        //         break;
        //     case "M":
        //         return Solicitud::where('user_id', auth()->id())
        //             ->where('tipo2', '=', 'M')
        //             ->orderBy('id', 'DESC')->get();
        //         break;
        //     default:
        //         return Solicitud::where('user_id', auth()->id())->orderBy('id', 'DESC')->get();
        // }

        return Pesa::where('user_id', auth()->id())->orderBy('id', 'DESC')->get();
    }

    public function storePesa(Request $request)
    {
        
        $dato = $request->except('token');
        /*$datosSolicitud['user_id'] = auth()->id();
        $datosSolicitud['periodo'] = date("Y");*/
        /*
        $usuario = auth()->id();*/
        //return $datosSolicitud;

        $ahora = date("Y-m-d H:i:s");
        $periodo = date("Y");
        
        $ctn_expedientes = Pesa::where('periodo', '=', $periodo)->distinct('resolucion')->count('resolucion');     
        $ctn_expedientes = $ctn_expedientes + 1;        
        $expediente = 'IMP-'. $ctn_expedientes . '-' . date("Y");
        
        //$datosSolicitud['expediente'] = $expediente;

        $ext = ".svg";
        $qrCode  = Uuid::generate()->string;
        $qr_certificacion = 'pdf/' . $qrCode . '.pdf';
        $cert = $qr_certificacion;
        
        /*$record = libro::create($datosSolicitud);
        $record->save();
        $last_data = $record->id;*/
        //return $last_data;
        

        //$dato = $datosSolicitud;      
        
        
        
        //$dato = $datosSolicitud;
        //foreach ($datosSolicitud as $dato) {
            // $nuevoRegistro = new Pesa(); // Crea una nueva instancia de TuModelo
            
            // Asigna todos los valores de los campos uno por uno

            foreach ($dato['instrumentos'] as &$instr) {
                $nuevoRegistro = new Pesa();

                $nuevoRegistro->fecha_presentacion = $ahora;            
                $nuevoRegistro->boleta = $dato['boleta'];
                $nuevoRegistro->correoelectronico = $dato['correoelectronico'];
                $nuevoRegistro->nombre_empresa = $dato['nombre_empresa'];
                $nuevoRegistro->nombre_comercial = $dato['nombre_comercial'];
                $nuevoRegistro->direccion = $dato['direccion'];
                $nuevoRegistro->departamento = $dato['departamento'];
                $nuevoRegistro->municipio = $dato['municipio'];
                $nuevoRegistro->telefono = $dato['telefono'];
                $nuevoRegistro->fax = $dato['fax'];
                // $nuevoRegistro->responsable = $dato['responsable'];
                // $nuevoRegistro->cargo = $dato['cargo'];
                // $nuevoRegistro->serie = $dato['serie'];
                // $nuevoRegistro->marca = $dato['marca'];
                // $nuevoRegistro->origen = $dato['origen'];
                // $nuevoRegistro->area = $dato['area'];
                // $nuevoRegistro->tipobalanza = $dato['tipobalanza'];
                // $nuevoRegistro->otrosdatos = $dato['otrosdatos'];
                $nuevoRegistro->responsable = $instr['responsable'];
                $nuevoRegistro->cargo = $instr['cargo'];
                $nuevoRegistro->serie = $instr['serie'];
                $nuevoRegistro->marca = $instr['marca'];
                $nuevoRegistro->origen = $instr['origen'];
                $nuevoRegistro->area = $instr['area'];
                $nuevoRegistro->tipobalanza = $instr['tipobalanza'];
                $nuevoRegistro->otrosdatos = $instr['otrosdatos'];

                $nuevoRegistro->user_id = auth()->id();
                $nuevoRegistro->periodo = $periodo;
                $nuevoRegistro->resolucion = $expediente;
                $nuevoRegistro->status = "ANALISIS";

                // Guarda el registro en la base de datos
                $nuevoRegistro->save();
            }
            $last_data = $nuevoRegistro->id;

            $url = 'https://www.diacoenlinea.net/certificaciones?qr=';
            QrCode::generate($url . $qrCode, public_path('/img/qr/' . $qrCode . $ext));
    
            $pdf = App::make('dompdf.wrapper');
            $svg_ = 'img/qr' . '/' . $qrCode . $ext;
            $logo_ = 'img/logo.png';
            $fondo = 'img/fondoa4.png';
    
            
    
           
    
                //HTML
                $html2 = '<!DOCTYPE html>
                <html>
                <head>
                <title>  ' . $expediente . '</title>
                <style type="text/css">
                @page {
                    size: A4;
                    margin: 0px;
                }
                @media print {
                    html, body {
                      font-size: 1em !important;
                      color: #000 !important;
                      font-family: Arial !important;
                      width: 210mm;
                      height: 297mm;
                    }
                }
                
                p {
                    font-family: arial, verdana, sans-serif; 
                    font-size: 14 px;
                }
                body {
                  background-image: url("img/fondoa4.png");
                  background-repeat: no-repeat;
                  background-attachment: fixed;
                  background-position: center;
                  background-size: cover;
                }
                .demo {                
                    border:1px solid #000000;
                    border-collapse:collapse;
                    padding:2px;
                    font-size: 14.5 px;
                    font-family: arial, verdana, sans-serif;
                }
                .demo th {
                    border:1px solid #000000;
                    padding:2px;
                }
                .demo td {
                    border:1px solid #000000;
                    padding:2px;                
                }
                .center {
                    width: 50%;
                    margin: 0 auto;
                }
                .center2 {            
                    text-align: center;
                }
    
                </style>
                </head>            
              
    
                <body>                     
                <br><br><br><br>
                <br><br><br>
                <div class="center2">
                <p> CONSTANCIA DE SOLICITUD DE AUTORIZACION DE INSTRUMENTOS DE MEDICION Y PESAJE<p>
                </div>
                <br><br>
                <table class="demo">
                <tbody>            
               
                <tr >
                <td >&nbsp;<b>Expediente:</b></td>
                <td >&nbsp;' . $expediente . '</td>
                <td ><b></b></td>
                <td >&nbsp;</td>
                </tr>
                <tr >
                <td >&nbsp;<b>Empresa:</b></td>
                <td >'.$dato['nombre_empresa'].'</td>
                <td >&nbsp;<b>Fecha de Emisi&oacute;n:</b></td>
                <td >&nbsp;' . $ahora . '</td>
                </tr>
                <tr >
                <td colspan="4"  >&nbsp;</td>         
                </tr>
                <tr >
                <td >&nbsp;<b>Nombre Comercial:</b></td>
                <td >&nbsp;' . $dato['nombre_comercial'] . '</td>
                <td ><b>Solicitante:</b></td>
                <td >&nbsp;' . $dato['responsable'] . '</td>
                
                </tr>
                <tr >
                <td ><b>Serie Instrumento:</b></td>
                <td >&nbsp;' . $dato['serie'] . '</td>
                <td ><b></b></td>
                <td >&nbsp;</td>            
                </tr>         
                <tr >
                <td ><b>' . $dato['marca'] . ':</b></td>
                <td >&nbsp;' . $dato['origen'] . '</td>
                <td ><b>Tipo Balanza:</b></td>
                <td >&nbsp;' . $dato['tipobalanza'] . '</td>
                </tr>                        
                </tbody>
                </table>
                <br>         
                <br>         
                <div class=".center">        
                <img src="' . $svg_ . '" alt="QR Code">                  
                <br>                            
                </div>
                </body>
                
                </html>';
                $pdf->loadHTML($html2);
                $pdf->setPaper("a4", "portrait");
            
            $path = public_path('/pdf');
            $fileName =  $qrCode . '.' . 'pdf';
            $pdf->save($path . '/' . $fileName);
            $file = $path . '/' . $fileName;
            $tmp_mail = $dato['correoelectronico'];

            $data["email"]=$tmp_mail;            
            $data["file"]=$file;            
            $data["exp"]=$expediente;            
            $datax = "NOTIFICACION: Sistema de control de expedientes Expediente: ".$expediente;

            Mail::send('notificacion.NotificacionIMP',$data, function($message)use($data) {
            $message->to($data["email"], $name = null);
            $message->subject("Sistema de control expedientes  Ref: ".$data["exp"]);
            $message->attach($data["file"]);                    
            $message->getSwiftMessage();                    
            });
            


        return $last_data;                
    }

    public function cargarArchivoImp(Request $request)
    {
        $datosSolicitud = $request; 

        $expediente = Pesa::where('id',$datosSolicitud['id_solicitud'])->first()->resolucion;                        
        $descripcion_archivo = Adjunto::where('id',$datosSolicitud['adjunto'])->first()->descripcion;

        Http::attach(
            'file', $request->file('file')->getPathname()
        )->post("http://localhost:3001/api/doc/cargar/archivo", [
            'adjunto' => $request->adjunto,
            // 'selector' => $request->selector,
            'expediente' => $expediente,
            'descripcion' => $descripcion_archivo,
            'type' => $request->file('file')->getClientMimeType()
        ]);
              
        if($request->hasFile('file')) {      
            $response = [
                'descripcion' => $descripcion_archivo,
                'filename' => $request->file('file')->getClientOriginalName(),
            ];
        } else {
            $response = [
                'descripcion' => '300',
                'filename' => null,
            ];
        }
        
        return response()->json($response);
    }

    public function boletaUpdateImp(Request $request)
    {
        //Datos boleta de pago
        $voucherSolicitud = $request;

        $voucherSolicitud['periodo'] = date("Y");

        //---- Generar numero de expediente ----
        $ctn_expedientes = Pesa::where('periodo', '=', $voucherSolicitud['periodo'])->distinct('resolucion')->count('resolucion');
        //PEX-D-1-2021
        // $ctn_expedientes = $ctn_expedientes + 1;
        $ctn_expedientes = $ctn_expedientes;
        //$expediente = 'DIACO-' . $datosSolicitud['tipo2'] . '-' . $ctn_expedientes . '-' . date("Y");
        $expediente = 'IMP-'. $ctn_expedientes . '-' . date("Y");
        //---------------------------------------

        Boleta::where('no_boleta', $voucherSolicitud['boleta'])->where('selector','IMP')->update(['expediente' => $expediente]);
    }

    public function show($id)
    {
        $libro = Libro::findOrFail($id);
        return view('libro.show', compact('libro'));
    }

    // Reporte cantidad
    public function obtenerCantImp(Request $request){

        $cantidad = Pesa::where('periodo', '=', $request->periodo)->whereMonth('fecha_presentacion', '=', $request->mes)->count();

        switch ($request->mes) {
            case 1:
                $mes = "Enero";
            break;
            case 2:
                $mes = "Febrero";
            break;
            case 3:
                $mes = "Marzo";
            break;
            case 4:
                $mes = "Abril";
            break;
            case 5:
                $mes = "Mayo";
            break;
            case 6:
                $mes = "Junio";
            break;
            case 7:
                $mes = "Julio";
            break;
            case 8:
                $mes = "Agosto";
            break;
            case 9:
                $mes = "Septiembre";
            break;
            case 10:
                $mes = "Octubre";
            break;
            case 11:
                $mes = "Noviembre";
            break;
            case 12:
                $mes = "Diciembre";
            break;
        }

        $response = [
            'mes' => $mes,
            'cantidad' => $cantidad
        ];

        return $response;
    }

    // Listar periodos por registro
    public function colocarPeriodosImp(){
        return Pesa::select('periodo')->groupBy('periodo')
        ->orderBy('periodo', 'desc')
        ->get();
    }

    //Generar Archivos
    function generarXmlImp(){

    }

}
