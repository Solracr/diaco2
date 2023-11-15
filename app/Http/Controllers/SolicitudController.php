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
use App\Models\Adjunto;
use App\Models\experiencia;
// Moldelos API
use App\Models\Archivo;
use App\Models\Boleta;
// Consumir API
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Jobs\previoPagoMail;
use Illuminate\Support\Facades\DB;

use App\Models\encuestas;

use PDF;
use QrCode;
use Uuid;
use Mail;

class SolicitudController extends Controller
{
    public function index(Request $request)
    {
        return Solicitud::where('user_id', auth()->id())->get();
    }

    public function certificaciones(Request $request)
    {
        $codigo = 300;
        try {
            $datosSolicitud = $request;
            $result = Registro::where('uuid', $datosSolicitud['uuid'])->get();
            $reader = Registro::where('uuid', $datosSolicitud['uuid'])->first();
            $qparam = $reader->expediente;
            $solicitud = Solicitud::where('expediente', $qparam)->first();
            $estado = $solicitud->status;
            $nombreCompleto = $solicitud->nombreCompleto;
            if (count($result) > 0) {
                $codigo = 200;
            }
            //} catch(\Illuminate\Database\QueryException $ex){ 
        } catch (Exception $e) {
            report($e);
            $result  = null;
            $nombre = '';
        }

        $respuesta = [
            'codigo' => $codigo,
            'datos' => $result,
            'nombre' => $nombreCompleto,
            'estado' => $estado
        ];

        return $respuesta;
        //return response()->json($respuesta);        
    }


<<<<<<< HEAD
=======
    public function getHtml($tipo,$concepto,$logo_,$currentDateTime){

        $html = '<html>
        <head>
        <title>Orden de Pago</title>
        </head>

        <style type = "text/css">
        
        
        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed, 
        figure, figcaption, footer, header, hgroup, 
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }
        
        article, aside, details, figcaption, figure, 
        footer, header, hgroup, menu, nav, section {
            display: block;
        }
        body {
            line-height: 1;
        }
        ol, ul {
            list-style: none;
        }
        blockquote, q {
            quotes: none;
        }
        blockquote:before, blockquote:after,
        q:before, q:after {                                        
            content: none;
        }
        table {
            border-collapse: collapse;
            border-spacing: 1;
            border:1px;
            width:90%;
            margin: auto;
        }

        p
        {
            text-align: justify;
            text-justify: inter-word;
            font-family: "Myriad Pro", "sans-serif";
            font-size: 10pt;
            color: #000000;
        }
        div{ 
            border: 5px solid white; 
            border-radius: 5px; 
            margin: auto; 
            text-align: center;
            } 

        </style>
        <body>
        <div style="width: 50%; float: left;">
        <table>
        <tbody>

    

        <tr>
            <td colspan="2"><img src="'.$logo.'" width="300" height="90" alt="Logo"></td>
        </tr>
        <br><br><br><br><br>
        <tr>
            <td colspan="2"><p style="text-align: center; font-weight: bold; font-size: 11px;">&nbsp;&nbsp;&nbsp;</p></td>
        </tr>
        
        <tr>
            <td colspan="2">                                    
            <p><strong><h1><b>TIPO DE PAGO  '.$tipo.'</b></h1></strong></p>                                    
            </td>                                    
        </tr>
        <tr>
            <td colspan="2">                                    
            <p><strong><h1><b>Monto Q. 50.00 </b></h1></strong></p>                                    
            </td>                                    
        </tr>
        <tr>
            <td colspan="2">                                    
                <p><strong><h1>'.$concepto.'	</h1></strong></p>                                    
            </td>                                    
        </tr>
        <tr>
        <td colspan="2">                                    
                
        </td>                                    
        </tr>
        
        
        </tbody>
        </table>
        <br>  
                        
        <p>
        &nbsp;'.$currentDateTime.'    
        </p>
        </div> 
        </body>
        </html>
        ';

        return $html;
    }

    public function generarBoleta(Request $request){
        $concepto = $request['concepto'];
        $tipo = $request['tipo'];
        $email = $request['correo'];
        $rx = '300';                                
        $periodo =  date("Y");            
        $uuid  = Uuid::generate()->string;            

        $logo = 'img/logo.png'; 
        $currentDateTime = date('Y-m-d H:i:s');
        
        $html = getHtml($tipo,$concepto,$logo_,$currentDateTime);
        $pdf = App::make('dompdf.wrapper');         
             
        $anio1 = date("Y");
        $anio2 = date("Y") + 1;
        $month = date('m');
        $day = date("d");
               
        $pdf = PDF::loadHTML($html);
        $pdf->setPaper([0, 0, 419.53, 595.28], "portrait"); // Tamaño personalizado para media carta

        $path = public_path('/upload');
        $date = date('Y_m_d_H_i_s');
        $fileName =  'NOTIFICACION_ORDENPAGO_' . $date . '.pdf';
        $pdf->save($path . '/' . $fileName);        
        $url = asset($path . '/' . $fileName);                                           
        $data["email"]=$email;            
        $data["file"]=$path . '/' . $fileName;                             
        Mail::send('notificacion.banrural_pagocontrato',$data, function($message)use($data) {
            $message->to($data["email"], $name = null);                    
            $message->subject("Sistema de control de expedientes ");                    
            $message->attach($data["file"]);
            $message->getSwiftMessage();                    
        });        
        $rx = [
            'code' => '200',                       
            'nombre_archivo' => $fileName
        ];                                   
        return $rx;
    }

>>>>>>> a6d14650e684b4ee169f5fc59ad3ee668d95ec5f
//codigo de contratos de adhesion    
    public function contratoUpload(Request $request)
    {
        $rx = '300';
        $ahora = date("Y-m-d H:i:s");    
        $datosSolicitud = $request; 

        $validId = ($datosSolicitud["id"] - 1 );
        $validId = $validId / 211;

        $solicitud = Solicitud::find($validId);
    
        if (!$solicitud) {
            return redirect()->back()->with('error', 'No se encontró la solicitud correspondiente.');
        }

        $expediente = Solicitud::where('id',$validId)->first()->expediente;                        
        $descripcion_archivo = "Contrato de adhesion revisado por el usuario";

    
        $request->validate([
            'archivo' => 'required|mimes:pdf|max:5000', // 5000KB o 5MB como tamaño máximo.
        ]);
    
        $fileName = 'ContratoRevisado_'.time() . '-' .$expediente.'.'.$request->archivo->getClientOriginalName();
        //$path = $request->file('archivo')->storeAs('public/contratos', $fileName);
        //$path = $request->file('archivo')->storeAs('upload', $fileName);
        $path = $request->file('archivo')->move(public_path('upload'), $fileName);        
        //$request->file_->move(public_path('upload'), $fileName);                            
    
        Requisito::create(
            //['tipo'=> 'Solicitud','descripcion' => $descripcion_archivo , 'archivo' => $fileName, 'expediente' => $expediente, 'user_id' =>auth()->id() ]
            ['tipo'=> 'Solicitud','descripcion' => $descripcion_archivo , 'archivo' => $fileName, 'expediente' => $expediente, 'user_id' =>auth()->id()]
        );      
        
        $rx = $descripcion_archivo;


        /*$url = Storage::url('public/uploads/' . $nombreArchivo);
        return response()->json(['url' => $url]);*/

        //$solicitud->archivo = $path;
        //$solicitud->save();

        $query = Solicitud::where('expediente',$datosSolicitud['expediente'])->first();                 
        $email = $query->correoElectronico;
        $analista = $query->analista_id;

        $query2 = User::where('id',$analista)->first();                
        $email_analista = $query2->email;


        $datax = " El Contrato de adhesión fue cargado al sistema con modificaciones";

        previoPagoMail::dispatch($email, $expediente.$datax, 903);
        previoPagoMail::dispatch($email_analista, $expediente.$datax, 903);

    
        return redirect()->back()->with('success', 'Archivo cargado con éxito.');        
        //return $rx;
    }


    public function storeLibro(Request $request)
    {
        //$datosSolicitud = $request;   

        $datosSolicitud = $request->except('token');
        $datosSolicitud['user_id'] = auth()->id();
        $periodo = date("Y");
        $status = 'ANALISIS';
        

        //        $date = date('Y M d h:i:s') // 2020 09 22 22:09:26 UTC
        $ahora = date("Y-m-d H:i:s");
        $nombreDepartamento = Departamento::where('id', $datosSolicitud['departamento'])->first();
        $ndep = $nombreDepartamento->nombre;


        /*if ($datosSolicitud['codigoEmpresa'] > 0) {
            $res_ = Empresa::where('id', $datosSolicitud['codigoEmpresa'])->first();
            $datosSolicitud['razonSocial'] = $res_->razonSocial;
        }*/

        $nombreMunicipio = Municipio::where('id', $datosSolicitud['municipio'])->first();
        $nmun = $nombreMunicipio->nombre;


        $today = date("Y-m-d");
        $diff = date_diff(date_create($datosSolicitud['fechaNacimiento']), date_create($today));
        $edad = $diff->format('%y');

        $ctn_expedientes = Solicitud::where('periodo', '=', $datosSolicitud['periodo'])->count();

        //PEX-D-1-2021
        $ctn_expedientes = $ctn_expedientes + 1;
        //$expediente = 'DIACO-' . $datosSolicitud['tipo2'] . '-' . $ctn_expedientes . '-' . date("Y");
        $expediente = 'LIBRO-'. $ctn_expedientes . '-' . date("Y");
        
        $datosSolicitud['expediente'] = $expediente;

        $ext = ".svg";
        $qrCode  = Uuid::generate()->string;
        $qr_certificacion = 'pdf/' . $qrCode . '.pdf';
        $datosSolicitud['qr'] = $qr_certificacion;
        //return $datosSolicitud;
        $record = Solicitud::create($datosSolicitud);
        $record->save();
        $last_data = $record->id;

        $result = DB::connection('mysql')->select('SELECT users.id FROM users join role_users on users.id=role_users.user_id left join  
        (SELECT analista_id,count(analista_id) as cantidad_solicitudes FROM solicituds group by analista_id order by count(analista_id) )
        sc1 on users.id = sc1.analista_id
        where role_users.role_id=3 and users.status!=2 order by cantidad_solicitudes asc limit 1');                
        
        
        //$array = json_decode(json_encode($result), true);
        $objectVar = $result[0]->id; 
        //return $objectVar;
        //return gettype($array);
        //return $array[0];
        $d_notificaciones = $datosSolicitud["direccion"];     
        
        $Actualizar = Solicitud::findOrFail($last_data);            
        $Actualizar->analista_id = $objectVar;  
        $Actualizar->save();
        
        
        /*        
        TRIGGER `solicituds_BEFORE_INSERT` BEFORE INSERT ON `solicituds` FOR EACH ROW BEGIN
            SET @varanalista := (SELECT users.id FROM users join role_users on users.id=role_users.user_id left join  
            (SELECT analista_id,count(analista_id) as cantidad_solicitudes FROM solicituds group by analista_id order by count(analista_id) ) sc1 on users.id = sc1.analista_id
            where role_users.role_id=3 and users.status!=2 order by cantidad_solicitudes asc limit 1) ;
                
                set NEW.analista_id = @varanalista;
        END
        */

        //$record = Solicitud::create($datosSolicitud->all());        
        Registro::create(
            ['expediente' => $expediente, 'archivo' => $qr_certificacion, 'uuid' => $qrCode, 'documento' => 'certificacion', 'referencia' => auth()->id(), 'estado' => 'ANALISIS', 'comentario' => 'Datos cargados correctamente al Sistema']
        );

        

        // DB::table('post')
        //     ->where('id', 3)
        //     ->update(['title' => "Updated Title"]);

        $nombreCompleto = $datosSolicitud['primerNombre'] . ' ' . $datosSolicitud['otrosNombres'] . ' ' . $datosSolicitud['primerApellido'] . ' ' . $datosSolicitud['otrosApellidos'] . ' ' . $datosSolicitud['apellidoCasada'];
        $data = [
            'title' => 'Certificacion',
            'date' => date('d/m/Y'),
            'expediente' => $qrCode . $ext
        ];
        //kali
        //$url = env("URL_SISTEMA");
        $url = 'https://www.diacoenlinea.net/certificaciones?qr=';
        QrCode::generate($url . $qrCode, public_path('/img/qr/' . $qrCode . $ext));

        $pdf = App::make('dompdf.wrapper');
        $svg_ = 'img/qr' . '/' . $qrCode . $ext;
        $logo_ = 'img/logo.png';
        $fondo = 'img/fondoa4.png';

        switch ($datosSolicitud['tipo2']) {
            case "D":
                $encabezado = 'EMPLEADORES QUE SOLICITAN AUTORIZACION PARA CONTRATAR EXTRANJEROS';
                break;
            case "A":
                $encabezado = 'EXTRANJEROS CASADOS O UNIDOS LEGALMENTE DE HECHO CON GUATEMALTECO O GUATEMALTECA';
                break;
            case "C":
                $encabezado = 'EXTRANJEROS QUE TENGAN LA PATRIA POTESTAD DE HIJOS GUATEMALTECOS';
                break;
            case "G":
                $encabezado = '';
                break;
            case "B":
                $encabezado = '';
                break;
            case "M":
                $encabezado = '';
                break;
            default:
                $encabezado = '';
        }


       

            //ACA VA EL FLUJO DE CONTRATOS DE ADHESION
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
            <p> CONSTANCIA DE SOLICITUD DE APROBACION DE CONTRATO DE ADHESION<p>
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
            <td >&nbsp;<b>Propietario:</b></td>
            <td >'.$datosSolicitud['profesion'].'</td>
            <td >&nbsp;<b>Fecha de Emisi&oacute;n:</b></td>
            <td >&nbsp;' . $ahora . '</td>
            </tr>
            <tr >
            <td colspan="4"  >&nbsp;</td>         
            </tr>
            <tr >
            <td >&nbsp;<b>Nombre Establecimiento:</b></td>
            <td >&nbsp;' . $datosSolicitud['nombre_establecimiento'] . '</td>
            <td ><b>Propietario:</b></td>
            <td >&nbsp;' . $datosSolicitud['razonSocial'] . '</td>
            
            </tr>
            <tr >
            <td ><b>Representante:</b></td>
            <td >&nbsp;' . $datosSolicitud['nombreCompleto'] . '</td>
            <td ><b></b></td>
            <td >&nbsp;</td>            
            </tr>         
            <tr >
            <td ><b>' . $datosSolicitud['documentoIdentificacion'] . ':</b></td>
            <td >&nbsp;' . $datosSolicitud['numeroDocumento'] . '</td>
            <td ><b>Nacionalidad:</b></td>
            <td >&nbsp;' . $datosSolicitud['nacionalidad'] . '</td>
            </tr>                        
            <tr >
            <td ><b>Sexo:</b></td>
            <td >&nbsp;' . $datosSolicitud['genero'] . '</td>
            <td ><b>Tel&eacute;fono:</b></td>
            <td >&nbsp;' . $datosSolicitud['numeroTelefono'] . '</td>
            </tr>
            <tr >
            <td ><b>Departamento Residencia:</b></td>
            <td >&nbsp;' . $ndep . '</td>
            <td ><b>Municipio Residencia:</b></td>
            <td >&nbsp;' . $nmun . '</td>
            </tr>
            <tr >
            <td ><b>Dirección Notificaciones:</b></td>
            <td >&nbsp;' . $datosSolicitud['direccion'] . '</td>
            <td ><b>Correo Electrónico:</b></td>
            <td >&nbsp;' . $datosSolicitud['correoElectronico']. '</td>
            </tr>            
            </tbody>
            </table>
            <br>         
            <br>         
            <div class=".center">        
            <img src="' . $svg_ . '" alt="QR Code">                  
            <br>            
            <p> UUID: ' . $qrCode . '  </p>
            </div>
            </body>
            
            </html>';
            $pdf->loadHTML($html2);
            $pdf->setPaper("a4", "portrait");
        

        //asignar solicitud a un analista
        //recuperar usuarios con rol analista status != 2
        //contar solicitudes por analista
        //el que sea menor asignar la solicitud


        $query2 = User::where('id',auth()->id())->first();
        $emailreceptor = $query2->email;

        $path = public_path('/pdf');
        $fileName =  $qrCode . '.' . 'pdf';
        $pdf->save($path . '/' . $fileName);
        $tmp_mail = $datosSolicitud['correoElectronico'];
        //previoPagoMail::dispatch($emailreceptor, $nombreCompleto, 200);
        previoPagoMail::dispatch($tmp_mail, $nombreCompleto, 200);
        //return $record->expediente;                
        return $record->id;
    }


    public function listadoSolicitudesEmpresa(Request $received_data)
    {

        $data = Solicitud::join('empresas', 'empresas.id', '=', 'solicituds.codigoEmpresa')
            ->orderBy('solicituds.id', 'DESC')
            ->where('solicituds.user_id', auth()->id())
            ->get([
                'solicituds.nombreCompleto', 'solicituds.nombrePlaza', 'solicituds.expediente', 'solicituds.status', 'empresas.razonSocial', 'solicituds.documentoIdentificacion',
                'solicituds.numeroDocumento', 'solicituds.qr', 'solicituds.created_at'
            ]);
        return $data;
        //return Solicitud::where('user_id', auth()->id())->orderBy('id', 'DESC')->get();        
    }

    public function obtenerSolicitudesEmpresa(Request $received_data)
    {
        $solicitud = $received_data['nivelEstudio'];
        //$solicitud = $datos['nivelEstudio'];          

        $data = Solicitud::leftjoin('empresas', 'empresas.id', '=', 'solicituds.codigoEmpresa')
            ->where('solicituds.expediente', '=', $solicitud)
            ->orderBy('solicituds.id', 'DESC')
            ->get([
                'solicituds.nombreCompleto', 'solicituds.nombrePlaza', 'solicituds.expediente', 'solicituds.status', 'empresas.razonSocial', 'solicituds.documentoIdentificacion',
                'solicituds.numeroDocumento', 'solicituds.qr', 'solicituds.created_at', 'solicituds.experiencia', 'solicituds.nivelEstudio', 'solicituds.idiomas', 'solicituds.primerNombre',
                'solicituds.otrosNombres', 'solicituds.primerApellido', 'solicituds.otrosApellidos', 'solicituds.apellidoCasada', 'solicituds.nacionalidad', 'solicituds.numeroTelefono',
                'solicituds.genero', 'solicituds.fechaNacimiento', 'solicituds.estadocivil', 'solicituds.direccion', 'solicituds.departamento', 'solicituds.municipio', 'solicituds.correoElectronico',
                'solicituds.periodicidadPago', 'solicituds.montoPago', 'solicituds.perfilPlaza', 'solicituds.funcionesGenerales', 'solicituds.situacionMigratoria', 'solicituds.partida',
                'solicituds.folio', 'solicituds.libro', 'solicituds.certificadoCui', 'solicituds.tipoEntidad'
            ]);


        //   $data =   array(
        //     "estado" => 2,
        //     "mensaje" =>  $solicitud);
        return $data;
        //return Solicitud::where('user_id', auth()->id())->orderBy('id', 'DESC')->get();        
    }

    public function listadoAnalista(Request $received_data)
    {
        $datosSolicitud = $received_data;
        $idUsuario = auth()->id();

        if ($datosSolicitud['status'] == "ANALISIS") {
            $s = Solicitud::whereIn('status', array($datosSolicitud['status'],'CANCELADO'))
                ->where('analista_id', '=', $idUsuario)
                //->where('codigoEmpresa',0)
                ->orderBy('id', 'DESC')->get();
            return $s;
        } else {
            $s = Solicitud::where('status', $datosSolicitud['status'])
                //->where('analista_id','=',$idUsuario)
                //->where('codigoEmpresa',0)
                ->orderBy('id', 'DESC')->get();
            return $s;
        }



        $data = Solicitud::join('empresas', 'empresas.id', '=', 'solicituds.codigoEmpresa')
            ->where('solicituds.status', $datosSolicitud['status'])
            ->where('solicituds.analista_id', '=', $datosSolicitud['analista'])
            ->orderBy('solicituds.id', 'DESC')
            ->get([
                'solicituds.nombreCompleto',
                'solicituds.nombrePlaza',
                'solicituds.expediente',
                'solicituds.status',
                'empresas.razonSocial',
                'solicituds.documentoIdentificacion',
                'solicituds.numeroDocumento',
                'solicituds.qr'
            ]);
        //return $data;

        $s = Solicitud::where('status', $datosSolicitud['status'])
            //->where('codigoEmpresa',0)
            ->orderBy('id', 'DESC')->get();
        return $data->merge($s);

        $c = Solicitud::leftJoin('empresas', function ($join) {
            $join->on('solicituds.codigoEmpresa', '=', 'empresas.id');
        })
            ->whereNull('empresas.id')
            ->first([
                'solicituds.id',
                'solicituds.nombreCompleto',
                'solicituds.nombrePlaza',
                'solicituds.expediente',
                'solicituds.status',
                'solicituds.documentoIdentificacion',
                'solicituds.numeroDocumento',
                'solicituds.qr',
                'solicituds.created_at'
            ]);
        return $c;
    }

    public function listadoAnalistaDashboard(Request $received_data)
    {
        $datosSolicitud = $received_data;

        $s = Solicitud::join('users', 'users.id', '=', 'solicituds.analista_id')
            ->join('role_users', 'role_users.user_id', '=', 'solicituds.analista_id')
            ->join('roles', 'roles.id', '=', 'role_users.role_id')
            ->join(
                DB::raw('(SELECT expediente, MAX(created_at) fecha_movimiento
                                    FROM `registros` GROUP BY expediente)
                                    UlmimoMovimiento'),
                function ($join) {
                    $join->on('solicituds.expediente', '=', 'UlmimoMovimiento.expediente');
                }
            )
            ->orderBy('solicituds.id', 'DESC')->get(['solicituds.*', 'users.name', 'roles.name as rol', 'UlmimoMovimiento.fecha_movimiento']); //where('status',$datosSolicitud['status'])
        //->where('analista_id','=',$datosSolicitud['analista'])
        //->where('codigoEmpresa',0)

        return $s;

        $data = Solicitud::join('empresas', 'empresas.id', '=', 'solicituds.codigoEmpresa')
            ->where('solicituds.status', $datosSolicitud['status'])
            ->where('solicituds.analista_id', '=', $datosSolicitud['analista'])
            ->orderBy('solicituds.id', 'DESC')
            ->get([
                'solicituds.nombreCompleto',
                'solicituds.nombrePlaza',
                'solicituds.expediente',
                'solicituds.status',
                'empresas.razonSocial',
                'solicituds.documentoIdentificacion',
                'solicituds.numeroDocumento',
                'solicituds.qr'
            ]);
        //return $data;

        $s = Solicitud::where('status', $datosSolicitud['status'])
            //->where('codigoEmpresa',0)
            ->orderBy('id', 'DESC')->get();
        return $data->merge($s);

        $c = Solicitud::leftJoin('empresas', function ($join) {
            $join->on('solicituds.codigoEmpresa', '=', 'empresas.id');
        })
            ->whereNull('empresas.id')
            ->first([
                'solicituds.id',
                'solicituds.nombreCompleto',
                'solicituds.nombrePlaza',
                'solicituds.expediente',
                'solicituds.status',
                'solicituds.documentoIdentificacion',
                'solicituds.numeroDocumento',
                'solicituds.qr',
                'solicituds.created_at'
            ]);
        return $c;
    }

    public function general(Request $request)
    {
        return Solicitud::orderBy('id', 'DESC')->get();
    }
//listado_encuestas
    public function listado_encuestas()
    {        
        //return Solicitud::where('user_id', auth()->id())->orderBy('id', 'DESC')->get();        
        return encuestas::orderBy('id', 'DESC')->get();        
    }

    public function listado_ticket()
    {        
        //return Solicitud::where('user_id', auth()->id())->orderBy('id', 'DESC')->get();        
        return it_ticket::orderBy('id', 'DESC')->get();        
    }




    public function listadoExpedientes(Request $selector)
    {
        $datosSolicitud = $selector;
        switch ($datosSolicitud['action']) {
            case "C":
                return Solicitud::where('user_id', auth()->id())
                    ->where('tipo2', '=', 'A')
                    ->orWhere('tipo2', '=', 'C')
                    ->orderBy('id', 'DESC')->get();
                break;
            case "R":
                return Solicitud::where('user_id', auth()->id())
                    ->where('tipo2', '=', 'G')
                    ->orWhere('tipo2', '=', 'B')
                    ->orderBy('id', 'DESC')->get();
                break;
            case "M":
                return Solicitud::where('user_id', auth()->id())
                    ->where('tipo2', '=', 'M')
                    ->orderBy('id', 'DESC')->get();
                break;
            default:
                return Solicitud::where('user_id', auth()->id())->orderBy('id', 'DESC')->get();
        }
    }

    public function nacionalidades()
    {
        //return Nacionalidad::orderBy('GENTILICIO_NAC', 'ASC')->all();           
        return Nacionalidad::orderBy('GENTILICIO_NAC', 'ASC')->get();
    }

    public function listadoAnalistas()
    {
        // DB::table('usermetas')
        // ->select('browser', DB::raw('count(*) as total'))
        // ->groupBy('browser')
        // ->get();
        //return Nacionalidad::orderBy('GENTILICIO_NAC', 'ASC')->get('GENTILICIO_NAC');           
        //return Solicitud::orderBy('analista_id', 'ASC')->get(['analista_id']);    
        $reserves = DB::table('solicituds')
            ->join('users', 'users.id', '=', 'solicituds.analista_id')
            ->select('users.name', DB::raw('count(solicituds.id) as total'))
            ->groupBy('solicituds.analista_id')
            ->get();
        return $reserves;
    }

    public function departamentos()
    {
        return Departamento::all();
    }

    public function experiencia()
    {
        return experiencia::all();
    }

    public function municipios(Request $request)
    {
        $datosSolicitud = $request;
        //return $datosSolicitud;      
        //return Municipio::where('departamento_id', $datosSolicitud['departamento'])->get();            
        return Municipio::where('departamento_id', $datosSolicitud['departamento'])->get();
    }

    public function idiomas()
    {
        //$result = DB::connection('bolsa')->table('josmo_js_job_idiomas')->select('nombre')->pluck('nombre')->toArray();
        $result = Idioma::select('IDIOMA')->pluck('IDIOMA')->toArray(); 
        //$result = DB::connection('bolsa')->table('josmo_js_job_idiomas')->select('nombre')->pluck('nombre')->toArray();
        //$result = DB::table('josmo_js_job_idiomas')->select('nombre')->pluck('nombre')->toArray();
        //return Idioma::select('IDIOMA')->pluck('IDIOMA')->toArray();        
        return $result;
    }

    public function requisitos(Request $request)
    {
        $datosSolicitud = $request;
        return Adjunto::where('selector', $datosSolicitud['selector'])
            ->where('tipoSolicitud', $datosSolicitud['tipoSolicitud'])
            ->get();
    }

    public function requisitosUpdate(Request $request)
    {
        $datosSolicitud = $request;
        return Adjunto::whereIn('id', $datosSolicitud['arreglo'])->get();
        //return DB::table('Adjuntos')->whereIn('id', $datosSolicitud['arreglo'])->get();            
    }

    public function store(Request $request)
    {
        //$datosSolicitud = $request;

        $datosSolicitud = $request->except('token');
        $datosSolicitud['user_id'] = auth()->id();
        $datosSolicitud['periodo'] = date("Y");
        $datosSolicitud['status'] = 'ANALISIS';
        $datosSolicitud['primerNombre']="." ;
        $datosSolicitud['otrosNombres']="." ;
        $datosSolicitud['primerApellido']="." ; 
<<<<<<< HEAD
        $datosSolicitud['otrosApellidos']="." ;

=======
        $datosSolicitud['otrosApellidos']="." ; 
        
>>>>>>> a6d14650e684b4ee169f5fc59ad3ee668d95ec5f

        //        $date = date('Y M d h:i:s') // 2020 09 22 22:09:26 UTC
        $ahora = date("Y-m-d H:i:s");
        $nombreDepartamento = Departamento::where('id', $datosSolicitud['departamento'])->first();
        $ndep = $nombreDepartamento->nombre;


        if ($datosSolicitud['codigoEmpresa'] > 0) {
            $res_ = Empresa::where('id', $datosSolicitud['codigoEmpresa'])->first();
            $datosSolicitud['razonSocial'] = $res_->razonSocial;
        }

        /*$carrera_ = carrera::where('id', $datosSolicitud['carrera'])->first();
        $carrera = $carrera_->descripcion;*/


        $nombreMunicipio = Municipio::where('id', $datosSolicitud['municipio'])->first();
        $nmun = $nombreMunicipio->nombre;


        $today = date("Y-m-d");
        $diff = date_diff(date_create($datosSolicitud['fechaNacimiento']), date_create($today));
        $edad = $diff->format('%y');

        /*$ctn_expedientes = Solicitud::where('tipo1','=', $datosSolicitud['tipo1'])
                                      ->where('tipo2','=', $datosSolicitud['tipo2'])
                                      ->where('periodo','=', $datosSolicitud['periodo'])->count();*/

        /*$ctn_expedientes = Solicitud::where('tipo2','=', $datosSolicitud['tipo2'])
                                    ->where('periodo','=', $datosSolicitud['periodo'])->count();*/

        $ctn_expedientes = Solicitud::where('periodo', '=', $datosSolicitud['periodo'])->count();

        //PEX-D-1-2021
        $ctn_expedientes = $ctn_expedientes + 1;
        //$expediente = 'DIACO-' . $datosSolicitud['tipo2'] . '-' . $ctn_expedientes . '-' . date("Y");
        $expediente = 'CA-'. $ctn_expedientes . '-' . date("Y");
        
        $datosSolicitud['expediente'] = $expediente;

        $ext = ".svg";
        $qrCode  = Uuid::generate()->string;
        $qr_certificacion = 'pdf/' . $qrCode . '.pdf';
        $datosSolicitud['qr'] = $qr_certificacion;
        //return $datosSolicitud;
        $record = Solicitud::create($datosSolicitud);
        $record->save();
        $last_data = $record->id;

        $result = DB::connection('mysql')->select('SELECT users.id FROM users join role_users on users.id=role_users.user_id left join  
        (SELECT analista_id,count(analista_id) as cantidad_solicitudes FROM solicituds group by analista_id order by count(analista_id) )
        sc1 on users.id = sc1.analista_id
        where role_users.role_id=3 and users.status!=2 order by cantidad_solicitudes asc limit 1');                
        
        
        //$array = json_decode(json_encode($result), true);
        $objectVar = $result[0]->id; 
        //return $objectVar;
        //return gettype($array);
        //return $array[0];
        $d_notificaciones = $datosSolicitud["direccion"];     
        
        $Actualizar = Solicitud::findOrFail($last_data);            
        $Actualizar->analista_id = $objectVar;  
        $Actualizar->save();
        
        
        /*        
        TRIGGER `solicituds_BEFORE_INSERT` BEFORE INSERT ON `solicituds` FOR EACH ROW BEGIN
            SET @varanalista := (SELECT users.id FROM users join role_users on users.id=role_users.user_id left join  
            (SELECT analista_id,count(analista_id) as cantidad_solicitudes FROM solicituds group by analista_id order by count(analista_id) ) sc1 on users.id = sc1.analista_id
            where role_users.role_id=3 and users.status!=2 order by cantidad_solicitudes asc limit 1) ;
                
                set NEW.analista_id = @varanalista;
        END
        */

        //$record = Solicitud::create($datosSolicitud->all());        
        Registro::create(
            ['expediente' => $expediente, 'archivo' => $qr_certificacion, 'uuid' => $qrCode, 'documento' => 'certificacion', 'referencia' => auth()->id(), 'estado' => 'ANALISIS', 'comentario' => 'Datos cargados correctamente al Sistema']
        );

        

        // DB::table('post')
        //     ->where('id', 3)
        //     ->update(['title' => "Updated Title"]);

        //$nombreCompleto = $datosSolicitud['primerNombre'] . ' ' . $datosSolicitud['otrosNombres'] . ' ' . $datosSolicitud['primerApellido'] . ' ' . $datosSolicitud['otrosApellidos'] . ' ' . $datosSolicitud['apellidoCasada'];
        $nombreCompleto = $datosSolicitud['profesion'];
        //$datosSolicitud['nombreCompleto'] = $datosSolicitud['profesion'];
        $data = [
            'title' => 'Certificacion',
            'date' => date('d/m/Y'),
            'expediente' => $qrCode . $ext
        ];
        //kali
        //$url = env("URL_SISTEMA");
        $url = 'https://www.diacoenlinea.net/certificaciones?qr=';
        QrCode::generate($url . $qrCode, public_path('/img/qr/' . $qrCode . $ext));

        $pdf = App::make('dompdf.wrapper');
        $svg_ = 'img/qr' . '/' . $qrCode . $ext;
        $logo_ = 'img/logo.png';
        $fondo = 'img/fondoa4.png';

        switch ($datosSolicitud['tipo2']) {
            case "D":
                $encabezado = 'EMPLEADORES QUE SOLICITAN AUTORIZACION PARA CONTRATAR EXTRANJEROS';
                break;
            case "A":
                $encabezado = 'EXTRANJEROS CASADOS O UNIDOS LEGALMENTE DE HECHO CON GUATEMALTECO O GUATEMALTECA';
                break;
            case "C":
                $encabezado = 'EXTRANJEROS QUE TENGAN LA PATRIA POTESTAD DE HIJOS GUATEMALTECOS';
                break;
            case "G":
                $encabezado = '';
                break;
            case "B":
                $encabezado = '';
                break;
            case "M":
                $encabezado = '';
                break;
            default:
                $encabezado = '';
        }


       

            //ACA VA EL FLUJO DE CONTRATOS DE ADHESION
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
            <p> CONSTANCIA DE SOLICITUD DE APROBACION DE CONTRATO DE ADHESION<p>
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
            <td >&nbsp;<b>Propietario:</b></td>
            <td >'.$datosSolicitud['profesion'].'</td>
            <td >&nbsp;<b>Fecha de Emisi&oacute;n:</b></td>
            <td >&nbsp;' . $ahora . '</td>
            </tr>
            <tr >
            <td colspan="4"  >&nbsp;</td>         
            </tr>
            <tr >
            <td >&nbsp;<b>Nombre Establecimiento:</b></td>
            <td >&nbsp;' . $datosSolicitud['nombre_establecimiento'] . '</td>
            <td ><b>Representante:</b></td>
            <td >&nbsp;' . $datosSolicitud['razonSocial'] . '</td>
            
            </tr>
            <tr >
            <td ><b>Propietario:</b></td>
            <td >&nbsp;' . $datosSolicitud['nombreCompleto'] . '</td>
            <td ><b></b></td>
            <td >&nbsp;</td>            
            </tr>         
            <tr >
            <td ><b>' . $datosSolicitud['documentoIdentificacion'] . ':</b></td>
            <td >&nbsp;' . $datosSolicitud['numeroDocumento'] . '</td>
            <td ><b>Nacionalidad:</b></td>
            <td >&nbsp;' . $datosSolicitud['nacionalidad'] . '</td>
            </tr>                        
            <tr >
            <td ><b>Sexo:</b></td>
            <td >&nbsp;' . $datosSolicitud['genero'] . '</td>
            <td ><b>Tel&eacute;fono:</b></td>
            <td >&nbsp;' . $datosSolicitud['numeroTelefono'] . '</td>
            </tr>
            <tr >
            <td ><b>Departamento Residencia:</b></td>
            <td >&nbsp;' . $ndep . '</td>
            <td ><b>Municipio Residencia:</b></td>
            <td >&nbsp;' . $nmun . '</td>
            </tr>
            <tr >
            <td ><b>Dirección Notificaciones:</b></td>
            <td >&nbsp;' . $datosSolicitud['direccion'] . '</td>
            <td ><b>Correo Electrónico:</b></td>
            <td >&nbsp;' . $datosSolicitud['correoElectronico']. '</td>
            </tr>            
            </tbody>
            </table>
            <br>         
            <br>         
            <div class=".center">        
            <img src="' . $svg_ . '" alt="QR Code">                  
            <br>            
            <p> UUID: ' . $qrCode . '  </p>
            </div>
            </body>
            
            </html>';
            $pdf->loadHTML($html2);
            $pdf->setPaper("a4", "portrait");
            //$svg_ = 'img/qr' . '/' . $qrCode . $ext;

        //asignar solicitud a un analista
        //recuperar usuarios con rol analista status != 2
        //contar solicitudes por analista
        //el que sea menor asignar la solicitud


        $query2 = User::where('id',auth()->id())->first();
        $emailreceptor = $query2->email;

        $path = public_path('/pdf');
        $fileName =  $qrCode . '.' . 'pdf';
        $pdf->save($path . '/' . $fileName);
        $tmp_mail = $datosSolicitud['correoElectronico'];
        //previoPagoMail::dispatch($emailreceptor, $nombreCompleto, 200);
        previoPagoMail::dispatch($tmp_mail, $nombreCompleto, 200);
        //return $record->expediente;                
        return $record->id;
    }

    public function boletaUpdate(Request $request)
    {
        //Datos boleta de pago
        $voucherSolicitud = $request;

        $voucherSolicitud['periodo'] = date("Y");

        //---- Generar numero de expediente ----
        $ctn_expedientes = Solicitud::where('periodo', '=', $voucherSolicitud['periodo'])->count();
        //PEX-D-1-2021
        // $ctn_expedientes = $ctn_expedientes + 1;
        $ctn_expedientes = $ctn_expedientes;
        //$expediente = 'DIACO-' . $datosSolicitud['tipo2'] . '-' . $ctn_expedientes . '-' . date("Y");
        $expediente = 'CA-'. $ctn_expedientes . '-' . date("Y");
        //---------------------------------------

        Boleta::where('no_boleta', $voucherSolicitud['noBoleta'])->where('selector', 'CA')->update(['expediente' => $expediente]);
    }

    public function cargarBoleta(Request $request)
    {   
        $response = Http::attach(
            'file', $request->file('file')->getPathname()
        )->post("http://localhost:3001/api/doc/cargar/boleta", [
            'selector' => $request->selector,
            'noBoleta' => $request->noBoleta,
            'fechaPago' => $request->fechaPago,
            'type' => $request->file('file')->getClientMimeType()
        ]);

        return $response;
    }

    public function update(Request $request, Solicitud $solicitud)
    {
        $datosSolicitud = $request->except('token');
        $datosSolicitud['user_id'] = auth()->id();
        $datosSolicitud['periodo'] = date("Y");
        $datosSolicitud['status'] = 'ANALISIS';
        $datosSolicitud['nombreCompleto'] = $datosSolicitud['primerNombre'] . ' ' . $datosSolicitud['otrosNombres'] . ' ' . $datosSolicitud['primerApellido'] . ' ' . $datosSolicitud['otrosApellidos'];


        //        $date = date('Y M d h:i:s') // 2020 09 22 22:09:26 UTC
        $ahora = date("Y-m-d H:i:s");
        $nombreDepartamento = Departamento::where('id', $datosSolicitud['departamento'])->first();
        $ndep = $nombreDepartamento->nombre;


        // if ($datosSolicitud['codigoEmpresa']>0){
        //     $res_ = Empresa::where('id',$datosSolicitud['codigoEmpresa'])->first();
        //     $datosSolicitud['razonSocial'] = $res_->razonSocial;            
        // }




        $nombreMunicipio = Municipio::where('id', $datosSolicitud['municipio'])->first();
        $nmun = $nombreMunicipio->nombre;


        $today = date("Y-m-d");
        $diff = date_diff(date_create($datosSolicitud['fechaNacimiento']), date_create($today));
        $edad = $diff->format('%y');

        /*$ctn_expedientes = Solicitud::where('tipo1','=', $datosSolicitud['tipo1'])
                                      ->where('tipo2','=', $datosSolicitud['tipo2'])
                                      ->where('periodo','=', $datosSolicitud['periodo'])->count();*/

        /*$ctn_expedientes = Solicitud::where('tipo2','=', $datosSolicitud['tipo2'])
                                    ->where('periodo','=', $datosSolicitud['periodo'])->count();*/
        $queryTipoAdjunto = Solicitud::where('expediente', $datosSolicitud['expediente'])->first();
        $idExp = $queryTipoAdjunto->id;

        $Actualizar = Solicitud::findOrFail($idExp);

        $Actualizar->primerNombre = $datosSolicitud['primerNombre'];
        $Actualizar->otrosNombres = $datosSolicitud['otrosNombres'];
        $Actualizar->primerApellido = $datosSolicitud['primerApellido'];
        $Actualizar->otrosApellidos = $datosSolicitud['otrosApellidos'];
        $Actualizar->apellidoCasada = $datosSolicitud['apellidoCasada'];
        $Actualizar->nombreCompleto = $datosSolicitud['nombreCompleto'];
        $Actualizar->numeroTelefono = $datosSolicitud['numeroTelefono'];
        $Actualizar->fechaNacimiento = $datosSolicitud['fechaNacimiento'];
        $Actualizar->nacionalidad = $datosSolicitud['nacionalidad'];
        $Actualizar->genero = $datosSolicitud['genero'];
        $Actualizar->estadoCivil = $datosSolicitud['estadoCivil'];
        $Actualizar->documentoIdentificacion = $datosSolicitud['documentoIdentificacion'];
        $Actualizar->numeroDocumento = $datosSolicitud['numeroDocumento'];
        $Actualizar->direccion = $datosSolicitud['direccion'];
        $Actualizar->departamento = $datosSolicitud['departamento'];
        $Actualizar->municipio = $datosSolicitud['municipio'];
        $Actualizar->correoElectronico = $datosSolicitud['correoElectronico'];
        $Actualizar->profesion = $datosSolicitud['profesion'];
        $Actualizar->perfilPlaza = $datosSolicitud['perfilPlaza'];
        $Actualizar->funcionesGenerales = $datosSolicitud['funcionesGenerales'];
        $Actualizar->periodicidadPago = $datosSolicitud['periodicidadPago'];
        $Actualizar->montoPago = $datosSolicitud['montoPago'];
        $Actualizar->situacionMigratoria = $datosSolicitud['situacionMigratoria'];
        //$Actualizar->razonSocial = $datosSolicitud['razonSocial'];        
        $Actualizar->tipo1 = $datosSolicitud['tipo1'];
        //$Actualizar->tipo2 = $datosSolicitud['tipo2'];        
        $Actualizar->status = $datosSolicitud['status'];
        $Actualizar->partida = $datosSolicitud['partida'];
        $Actualizar->folio = $datosSolicitud['folio'];
        $Actualizar->libro = $datosSolicitud['libro'];
        $Actualizar->certificadoCui = $datosSolicitud['certificadoCui'];
        $Actualizar->expedienteMigracion = $datosSolicitud['expedienteMigracion'];
        $Actualizar->tipoParentesco = $datosSolicitud['tipoParentesco'];
        $Actualizar->fechaIngreso = $datosSolicitud['fechaIngreso'];
        $Actualizar->trabajoActual = $datosSolicitud['trabajoActual'];
        $Actualizar->ultimasOcupaciones = $datosSolicitud['ultimasOcupaciones'];
        $Actualizar->parientes = $datosSolicitud['parientes'];
        $Actualizar->motivoCancelacion = $datosSolicitud['motivo'];
        $Actualizar->fechaSolicitudCancelacion = $datosSolicitud['fechaCancelacion'];
        $Actualizar->updated_at = $ahora;

        
        

        if ($datosSolicitud['tipo2'] == 'Z') {
            //$record = Solicitud::create($datosSolicitud->all());        
            Registro::create(
                ['expediente' => $datosSolicitud['expediente'], 'archivo' => '', 'uuid' => '', 'documento' => 'Desistimiento', 'referencia' => auth()->id(), 'estado' => 'CANCELADO', 'comentario' => $datosSolicitud['motivo']]
            );

            $Actualizar->status = 'CANCELADO';

        }


        $Actualizar->save();
        return $idExp;
    }

    public function destroy(Solicitud $solicitud)
    {
        //
    }

    // Reportes
    // Reporte cantidad
    public function obtenerCantCa(Request $request){

        $cantidad = Solicitud::where('periodo', '=', $request->periodo)->whereMonth('created_at', '=', $request->mes)->count();

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
    public function colocarPeriodosCa(){
        return Solicitud::select('periodo')->groupBy('periodo')
        ->orderBy('periodo', 'desc')
        ->get();
    }
}




 /*$c = Solicitud::leftJoin('empresas', function($join) {
            $join->on('solicituds.codigoEmpresa', '=', 'empresas.id');
          })
          ->whereNull('empresas.id')
          ->first([
              'solicituds.id',
              'solicituds.nombreCompleto',
              'solicituds.nombrePlaza',
              'solicituds.expediente',
              'solicituds.phone',
              'solicituds.address1',
              'solicituds.address2',
              'solicituds.city',
              'solicituds.state',
              'solicituds.county',
              'solicituds.district',
              'cussolicitudstomers.postal_code',
              'solicituds.country'
          ]);*/
          //ANALISIS

/*
          $words_default = DefaultWord::where('word','LIKE',"%{$search}%")
               ->limit(10)
               ->get();*/