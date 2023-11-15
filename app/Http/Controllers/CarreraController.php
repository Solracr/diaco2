<?php

namespace App\Http\Controllers;

use DB;
use App\Models\carrera;
use Illuminate\Http\Request;
use App\Jobs\previoPagoMail;
use Illuminate\Support\Facades\App;
use Luecano\NumeroALetras\NumeroALetras;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Solicitud;
use App\Models\Ocupacion;
use App\Models\nivelacademico;
use App\Models\Requisito;
use GuzzleHttp\Client;
use Mail;
use PDF;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexObtenerListado(Request $request)
    {
        $datosSolicitud = $request;
        //return $datosSolicitud['nivelEstudio'];     
        return carrera::where('nivel_id', $datosSolicitud['nivelEstudio'])->get();
        //return carrera::get();                    
    }

    
    
    public function busquedaBolsa(Request $request)
    {        
        $id_carrera = $request['id_carrera'];
        $id_ocupacion = $request['id_ocupacion'];
        $id_experiencia = $request['id_experiencia'];
        $id_idiomas = $request['id_idiomas'];
        $tipo_empresa = $request['tipoEntidad'];
        $id_empresa = $request['id_empresa'];
        $nivel_academico = $request['nivel_academico'];
        $nombre_plaza = $request['nombre_plaza'];
        $especial = $request['especial'];

        $vectorIdiomas = explode(" ", $id_idiomas);

        $cnt = 0;              
        $result = '0';
        if($especial == "1"){
            $result = 'x';
        }else{            
            foreach ($vectorIdiomas as $key) {
                $client = new \GuzzleHttp\Client();
                $res = $client->request('GET', 'https://tuempleo.mintrabajo.gob.gt/api/pex',  [
                    \GuzzleHttp\RequestOptions::HEADERS => [
                        'api-key' => '$2y$10$Jc6QptrX/.SU0Kcy23SyWOesaSjLmg44pxIMxWXHtu6/HsIOs12HS',
                    ],
                    \GuzzleHttp\RequestOptions::QUERY => [
                        'id_carrera' => $id_carrera,
                        'id_ocupacion' =>$id_ocupacion,
                        'tipo_empresa' => $tipo_empresa,
                        'id_experiencia' => $id_experiencia,
                        'id_idiomas' => $key
                    ]
                ]);
                $r =  json_decode($res->getBody()->getContents());
                if($r->code == 300){
                    $result = 'x';
                }else{                    
                    $cnt++;
                }
            }           
        }

        if($cnt == count($vectorIdiomas)){
            $result = 'true';
        }else{
            $result = 'x';
        }
        
        $queryTipoAdjunto = carrera::where('id',$id_experiencia)->first();
        $descCarrera = $queryTipoAdjunto->descripcion;
        $queryTipoAdjunto = nivelacademico::where('id',$nivel_academico)->first();
        $descGrado = $queryTipoAdjunto->descripcion;
        $queryTipoAdjunto = Ocupacion::where('id',$id_ocupacion)->first();
        $descOcupacion = $queryTipoAdjunto->descripcion;
        ///Correo de busqueda

        $anio1 = date("Y");
                                    $anio2 = date("Y") + 1;

                                    $month = date('m');
                                    $day = date("d");

                                    $formatter = new NumeroALetras();
                                    $dia =  $formatter->toWords($day);
                                    if($month == 1) $mes = 'ENERO';
                                    if($month == 2) $mes = 'FEBRERO';
                                    if($month == 3) $mes = 'MARZO';
                                    if($month == 4) $mes = 'ABRIL';
                                    if($month == 5) $mes = 'MAYO';
                                    if($month == 6) $mes = 'JUNIO';
                                    if($month == 7) $mes = 'JULIO';
                                    if($month == 8) $mes = 'AGOSTO';
                                    if($month == 9) $mes = 'SEPTIEMBRE';
                                    if($month == 10) $mes = 'OCTUBRE';
                                    if($month == 11) $mes = 'NOVIEMBRE';
                                    if($month == 12) $mes = 'DICIEMBRE';
                                    
                                    $anioactual =  $formatter->toWords($anio1);
                                    $proximoanio =  $formatter->toWords($anio2);                                    

                                    $fechaInicial = $dia." DE ".$mes.' DEL AÑO '.$anioactual;

                                    //$result = carrera::where('id',$id_experiencia)->first();
        if ($result == 'x') 
        {
            $pdf = App::make('dompdf.wrapper');  
            $queryEmpresa = Empresa::where('id', $id_empresa)->first();
            //$nombreEmpresa = $queryEmpresa->razonSocial;
            //$nombreRepresentante = $queryEmpresa->primerNombreRepresentante . ' ' . $queryEmpresa->otrosNombresRepresentante . ' ' . $queryEmpresa->primerApellidoRepresentante . ' ' . $queryEmpresa->segundoApellidoRepresentante;
            //$nombreCompleto = $queryEmpresa->primerNombre.' '.$queryEmpresa->otrosNombres.' '.$queryEmpresa->primerApellido.' '.$queryEmpresa->otrosApellidos.' '.$queryEmpresa->apellidoCasada;                
        
            $html = '<!DOCTYPE html>
    <html>
    <head>
                                    <title>Permisos de Trabajo a Extranjeros</title>
                                    </head>

                                    <style type="text/css">
                                    @page {
                                        size: A4;
                                        margin: 30px;
                                    }
                                    @media print {
                                        html, body {
                                          font-size: 2em !important;
                                          color: #000 !important;
                                          font-family: Arial !important;
                                          width: 210mm;
                                          height: 297mm;
                                        }
                                    }
                                    p {
                                        font-family: arial, verdana, sans-serif; 
                                        font-size: 12 px;
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
                                        font-size: 10.5 px;
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
                                    </style>
                                    <body>
                                    <br><br><br><br>
                                    <br><br><br><br>
                                    <br><br>
                                    <div> 
                                    <table >
                                    <tbody>

                                    
                                    
                                    <tr>
                                        <td colspan="2" style="text-align:right;align-content:right;">                                    
                                        <p>MINISTERIO DE TRABAJO Y PREVISION SOCIAL. GUATEMALA, <strong>'.$fechaInicial.' </strong></p>                                    
                                        </td>                                    
                                    </tr>

                                    <tr>

                                    <td colspan="2"><br>
                                    <p>Se le informa que <span style="font-weight: bold;">NO</span> existe personal guatemalteco que llene los requisitos para el cargo de “<span style="font-weight: bold;">'.$nombre_plaza.'”</span>, en la bolsa electrónica de empleo.</p></td>

                                    </tr>

                                    <tr>
                                    <td><br>
                                    <p>Según requisitos para la plaza:</p></td>

                                    </tr>

                                    

                                    <tr>
                                        <td colspan="2">                                    
                                        <p> •	Grado académico: '.$descGrado.'</p>                                    
                                        </td>             
                                    </tr>                            
                                    <tr>
                                        <td colspan="2">                                    
                                        <p> •	Carrera: '.$descCarrera.'</p>                                    
                                        </td>             
                                    </tr>                            
                                    <tr>
                                        <td colspan="2">                                    
                                        <p> •	Ocupación: '.$descOcupacion.'</p>                                    
                                        </td>             
                                    </tr>                            
                                    <tr>
                                        <td colspan="2">                                    
                                        <p> •	Idioma: '.$id_idiomas.'</p>                                    
                                        </td>             
                                    </tr>                            
                                    
                                    <tr>
                                        
                                    <td><br><p >Consulta realizada por la entidad <span style="font-weight: bold;">'.$queryEmpresa->razonSocial.'</span> </p></td>

                                    </tr>
                                    </tbody>
                                    </table>
                                    <br>  
                                    <br>         
                                    
                                    </div> 
                                    </body>
    
    </html>';

            $pdf->loadHTML($html);
            $pdf->setPaper("a4", "portrait");

            $path = public_path('/pdf');
            $fileName =  'busquedaBolsa' . '.' . 'pdf';
            $pdf->save($path . '/' . $fileName);

            $mail = $queryEmpresa->correo;
            $file = $path . '/' . $fileName;                  
            //$mail =auth()->email;
            $data["email"]=$mail;            
            $data["file"]=$file;            
            
            Mail::send('notificacion.notificacionBolsa',$data, function($message)use($data) {
      
                //$message->from($address, $name = null);
                //$message->sender($address, $name = null);
                $message->to($data["email"], $name = null);
                //$message->cc($address, $name = null);
                //$message->bcc($address, $name = null);
                //$message->replyTo($address, $name = null);
                $message->subject("Prueba");
                //$message->priority($level);
                //$message->attach($pathToFile, array $options = []);
                $message->attach($data["file"]);
                
                // Attach a file from a raw $data string...
                //$message->attachData($data, $name, array $options = []);
                
                // Get the underlying SwiftMailer message instance...
                $message->getSwiftMessage();
                /*$message->to($data["email"], $data["client_name"])
                ->subject($data["subject"]);*/            
        });

            //previoPagoMail::dispatch($queryEmpresa->correo,$pdf, 202);
        }
        else
        {
            $pdf = App::make('dompdf.wrapper');  
            $queryEmpresa = Empresa::where('id', $id_empresa)->first();
            //$nombreEmpresa = $queryEmpresa->razonSocial;
            //$nombreRepresentante = $queryEmpresa->primerNombreRepresentante . ' ' . $queryEmpresa->otrosNombresRepresentante . ' ' . $queryEmpresa->primerApellidoRepresentante . ' ' . $queryEmpresa->segundoApellidoRepresentante;
            //$nombreCompleto = $queryEmpresa->primerNombre.' '.$queryEmpresa->otrosNombres.' '.$queryEmpresa->primerApellido.' '.$queryEmpresa->otrosApellidos.' '.$queryEmpresa->apellidoCasada;                
        
            $html = '<!DOCTYPE html>
    <html>
    <head>
                                    <title>Permisos de Trabajo a Extranjeros</title>
                                    </head>

                                    <style type="text/css">
                                    @page {
                                        size: A4;
                                        margin: 30px;
                                    }
                                    @media print {
                                        html, body {
                                          font-size: 2em !important;
                                          color: #000 !important;
                                          font-family: Arial !important;
                                          width: 210mm;
                                          height: 297mm;
                                        }
                                    }
                                    p {
                                        font-family: arial, verdana, sans-serif; 
                                        font-size: 12 px;
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
                                        font-size: 10.5 px;
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
                                    </style>
                                    <body>
                                    <br><br><br><br>
                                    <br><br><br><br>
                                    <br><br>
                                    <div> 
                                    <table >
                                    <tbody>

                                    
                                    
                                    <tr>
                                        <td colspan="2" style="text-align:right;align-content:right;">                                    
                                        <p>MINISTERIO DE TRABAJO Y PREVISION SOCIAL. GUATEMALA, <strong>'.$fechaInicial.' </strong></p>                                    
                                        </td>                                    
                                    </tr>

                                    <tr>

                                    <td colspan="2"><br>
                                    <p>Se le informa que <span style="font-weight: bold;">SI</span> existe personal guatemalteco que llene los requisitos para el cargo de “<span style="font-weight: bold;">'.$nombre_plaza.'”</span>, en la bolsa electrónica de empleo.</p></td>

                                    </tr>

                                    <tr>
                                    <td><br>
                                    <p>Según requisitos para la plaza:</p></td>

                                    </tr>

                                    

                                    <tr>
                                        <td colspan="2">                                    
                                        <p> •	Grado académico: '.$descGrado.'</p>                                    
                                        </td>             
                                    </tr>                            
                                    <tr>
                                        <td colspan="2">                                    
                                        <p> •	Carrera: '.$descCarrera.'</p>                                    
                                        </td>             
                                    </tr>                            
                                    <tr>
                                        <td colspan="2">                                    
                                        <p> •	Ocupación: '.$descOcupacion.'</p>                                    
                                        </td>             
                                    </tr>                            
                                    <tr>
                                        <td colspan="2">                                    
                                        <p> •	Idioma: '.$id_idiomas.'</p>                                    
                                        </td>             
                                    </tr>                            
                                    
                                    <tr>
                                        
                                    <td><br><p >Consulta realizada por la entidad <span style="font-weight: bold;">'.$queryEmpresa->razonSocial.'</span> </p></td>

                                    </tr>
                                    </tbody>
                                    </table>
                                    <br>  
                                    <br>         
                                    
                                    </div> 
                                    </body>
    
    </html>';

            $pdf->loadHTML($html);
            $pdf->setPaper("a4", "portrait");

            $path = public_path('/pdf');
            $fileName =  'busquedaBolsa'.rand(). '.' . 'pdf';
            $pdf->save($path . '/' . $fileName);

            //Requisito::insert(
            //    ['descripcion' => 'Busqueda de Bolsa', 'archivo' => $fileName, 'expediente' => $expediente, 'user_id' =>auth()->id() ]            
            //);

            $mail = $queryEmpresa->correo;
            $file = $path . '/' . $fileName;
              
            $data["email"]=$mail;            
            $data["file"]=$file;            
            
            Mail::send('notificacion.notificacionBolsa',$data, function($message)use($data) {

                //$message->from($address, $name = null);
                //$message->sender($address, $name = null);
                $message->to($data["email"], $name = null);
                //$message->cc($address, $name = null);
                //$message->bcc($address, $name = null);
                //$message->replyTo($address, $name = null);
                $message->subject("Sistema de control de expedientes");
                //$message->priority($level);
                //$message->attach($pathToFile, array $options = []);
                $message->attach($data["file"]);
                
                // Attach a file from a raw $data string...
                //$message->attachData($data, $name, array $options = []);
                
                // Get the underlying SwiftMailer message instance...
                $message->getSwiftMessage();
                /*$message->to($data["email"], $data["client_name"])
                ->subject($data["subject"]);*/            
        });
            //previoPagoMail::dispatch($queryEmpresa->correo,$pdf, 202);
            //previoPagoMail::dispatch($queryEmpresa->correo, "", 202);
        }


        return $result;
    }
}
