<?php

namespace App\Http\Controllers;
use App\Jobs\previoPagoMail;
use App\Models\Previo;
use App\Models\Registro;
use App\Models\Requisito;
use App\Models\Evento;
use App\Models\User;
use App\Models\Solicitud;
use App\Models\Adjunto;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Luecano\NumeroALetras\NumeroALetras;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
// Moldelos API
use App\Models\Archivo;
use App\Models\Boleta;
// Consumir API
use Illuminate\Support\Facades\Http;
use Mail;
use Uuid;
use PDF;
use QrCode;


class RegistroController extends Controller
{


    public function actualizar(Request $request){
        $rx = '300';
        $datosSolicitud = $request;
        
        $evento = $datosSolicitud['evento_id'];
        $expediente = $datosSolicitud['expediente'];
        $comentario = $datosSolicitud['comentario'];
        //return $datosSolicitud;

        if ($evento == 6 || $evento == 8) {
            
            $token_evento = "";
            if($evento == 6) $token_evento = "RECHAZO";
            if($evento == 8) $token_evento = "NOTIFICACION";

            $periodo =  date("Y");
            $ctn_expedientes = 0;
            $uuid  = Uuid::generate()->string;
            $documento = "";

            $query = Solicitud::where('expediente',$datosSolicitud['expediente'])->first();                
            $id = $query->id;
            $usuario = $query->user_id;
            //$expediente = $query->expediente;
            $nombre = $query->nombreCompleto;        
            $razonSocial = $query->razonSocial;
            
            $query = Evento::where('id',$datosSolicitud['evento_id'])->first();                
            $status = $query->categoria;
            $comentarioBitacora = $query->descripcion;


            $ctn_expedientes = Registro::where('documento','=', $token_evento.'-J-')
            ->where('periodo','=',$periodo)->count();
            $ctn_expedientes = $ctn_expedientes + 1;   

            $providencia = $token_evento.'-J-'.$ctn_expedientes.'-'.$periodo;                                     
            $documento = $token_evento;
            $ahora = date("Y-m-d H:i:s");
            $vencimiento = date('Y-m-d', strtotime($ahora. ' + 5 days'));
            Previo::create(
                [
                    'observaciones'=>$comentario,
                    'previo'=>$providencia,
                    'expediente' => $expediente, 
                    'user_id' => auth()->id(), 
                    'estado' => $token_evento, 
                    'fechahoraRegistro' => $ahora , 
                    'fechahoraVencimiento' => $vencimiento
                ]
            );    

            $ext = ".svg";        
            $qrCode  = Uuid::generate()->string;            
            $qr_certificacion = $qrCode.'.pdf';            
            $url = 'https://www.diacoenlinea.net/certificaciones?qr=';
            QrCode::generate($url.$qrCode.'&t=res', public_path('/img/qr/'.$qrCode.$ext));       

            $pdf = App::make('dompdf.wrapper');         
            $svg_ = 'img/qr'.'/'.$qrCode.$ext;        
            $logo_ = 'img/logo.png'; 

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
            $fechaFinal = $dia." DE ".$mes.' DEL AÑO '.$proximoanio;
            
            $currentDateTime = date('Y-m-d H:i:s');
            $user = Auth::user()->name;
                            
            $html = '<html>
            <head>
            <title> '.$token_evento.' '.$expediente.'</title>
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
            <div> 
            <table>
            <tbody>

        

            <tr>
                <td colspan="2"><img src="'.$logo_.'" width="300" height="90" alt="Logo"></td>
            </tr>
            <br><br><br><br><br>
            <tr>
                <td colspan="2"><p style="text-align: center; font-weight: bold; font-size: 11px;">Expediente:&nbsp;&nbsp;&nbsp;<strong>'.$expediente.'&nbsp;&nbsp;</strong><br><br> </b></p></td>
            </tr>
            
            <tr>
                <td colspan="2">                                    
                <p><strong><h1>'.$token_evento.' DE SOLICITUD </h1></strong></p>                                    
                </td>                                    
            </tr>
            <tr>
                <td colspan="2">                                    
                    <p><strong><h1>APROBACION  Y REGISTRO DE CONTRATOS DE ADHESION	</h1></strong></p>                                    
                </td>                                    
            </tr>
            
            <tr>
            <td colspan="2">                                    
                    <p><strong>'.$comentario.'</strong></p>                                    
            </td>                                    
            </tr>';
            
$validator = ($id * 211) + 1;

            $html1 = '
            <tr>
            <td colspan="2">                                    
                    <p><strong>Llave: '.$validator.'</strong></p>                                    
            </td>                                    
            </tr>
            ';

            $html2 = '</tbody>
            </table>
            <br>  
            <br>         
            <img src="'.$svg_.'" alt="QR Code">                  
            <br>            
            <p>UUID: '. $qrCode.'</p>  
            <br>
            <p>
            '.$user.'&nbsp;'.$currentDateTime.'    
            </p>
            </div> 
            </body>
            </html>
            ';



            if($evento == 6){
                $html = $html.$html2;
            }elseif($evento == 8){
                $html = $html.$html1.$html2;
            }


            $pdf = PDF::loadHTML($html);
            $pdf->setPaper("a4", "portrait");
            
            $path = public_path('/upload');   
            $date = date('Y_m_d_H_i_s');      
            $fileName =  $token_evento.'_'.$date.'_'.$qrCode.'.'.'pdf' ;   
            $pdf->save($path . '/' . $fileName);                        
            
            //return $pdf->download($fileName);
            $url = asset($path . '/' . $fileName);
                                
                Registro::create(
                    [
                        'expediente' => $expediente, 
                        'archivo' => $fileName, 
                        'uuid' => $qrCode, 
                        'documento' => $token_evento, 
                        'dictamen' => $providencia,
                        'referencia' => auth()->id(), 
                        'estado' => $token_evento, 
                        'comentario' => $comentario,                                            
                        'periodo' => $periodo
                    ]
                );  
                
                $query = Solicitud::where('expediente',$expediente)->first();                
                
                $email = $query->correoElectronico;
                $Actualizar = Solicitud::findOrFail($id);            
                $status = $token_evento;
                $Actualizar->status = $status;                
                $Actualizar->save();


                //previoPagoMail::dispatch($email,$path.$fileName,701);            


                
                $data["email"]=$email;            
                $data["file"]=$path . '/' . $fileName;            
                $data["exp"]=$expediente;            
                $datax = "Sistema de control de expedientes Expediente: ".$expediente;

                if($evento == 6){
                    Mail::send('notificacion.Rechazo',$data, function($message)use($data) {
                        $message->to($data["email"], $name = null);
                        $message->subject("Sistema de control de expedientes Expediente: ".$data["exp"]);
                        $message->attach($data["file"]);                    
                        $message->getSwiftMessage();                    
                    });
                }elseif($evento == 8){
                        Mail::send('notificacion.Notificacion',$data, function($message)use($data) {
                        $message->to($data["email"], $name = null);
                        $message->subject("Sistema de control de expedientes Expediente: ".$data["exp"]);
                        $message->attach($data["file"]);                    
                        $message->getSwiftMessage();                    
                    });
                }

                

                $rx = [
                    'code' => '200',            
                    'nombre_archivo' => $fileName
                ];           
                        
                return $rx;
        }



        if ($evento == 7)
        {            
            $periodo =  date("Y");
            
            $uuid  = Uuid::generate()->string;            

            $query = Solicitud::where('expediente',$datosSolicitud['expediente'])->first();                
            $id = $query->id;
            $usuario = $query->user_id;
            
            $nombre = $query->nombreCompleto;        
            $razonSocial = $query->razonSocial;
            
            $query = Evento::where('id',$datosSolicitud['evento_id'])->first();                
            $status = $query->categoria;
            $comentarioBitacora = $query->descripcion;
            $notificacion = $comentarioBitacora;

            $ctn_expedientes = Registro::where('documento','=', 'NCA-J-')
            ->where('periodo','=',$periodo)->count();
            $ctn_expedientes = $ctn_expedientes + 1;   

            $providencia = 'NCA-J-'.$ctn_expedientes.'-'.$periodo;                                     
            $documento = 'notificacion';
            $ahora = date("Y-m-d H:i:s");
            $vencimiento = date('Y-m-d', strtotime($ahora. ' + 5 days'));
            Previo::create(
                [
                    'observaciones'=>$comentario,
                    'previo'=>$providencia,
                    'expediente' => $expediente, 
                    'user_id' => auth()->id(), 
                    'estado' => 'PENDIENTE', 
                    'fechahoraRegistro' => $ahora , 
                    'fechahoraVencimiento' => $vencimiento
                ]
            );    

            $ext = ".svg";        
            $qrCode  = Uuid::generate()->string;
            //$qr_certificacion = 'pdf/'.$qrCode.'.pdf';
            $qr_certificacion = $qrCode.'.pdf';
            


            //$url = env("URL_SISTEMA");  
            $url = 'https://www.diacoenlinea.net/certificaciones?qr=';
            QrCode::generate($url.$qrCode.'&t=res', public_path('/img/qr/'.$qrCode.$ext));       

            $pdf = App::make('dompdf.wrapper');         
            $svg_ = 'img/qr'.'/'.$qrCode.$ext;        
            $logo_ = 'img/logo.png'; 

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
            $fechaFinal = $dia." DE ".$mes.' DEL AÑO '.$proximoanio;
            
            $currentDateTime = date('Y-m-d H:i:s');
            $user = Auth::user()->name;
                            

            /*$pdf = \PDF::loadView('vista-pdf', $data);
            $pdf = $pdf->loadView('resoluciones.res_a_nuevo', compact('store'));
            
            $pdf = $pdf->loadView('resoluciones.res_a_nuevo', $data);*/

            $html = '<html>
            <head>
            <title>Notificación de tramite '.$expediente.'</title>
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
            <div> 
            <table>
            <tbody>

        

            <tr>
                <td colspan="2"><img src="'.$logo_.'" width="300" height="90" alt="Logo"></td>
            </tr>
            <br><br><br><br><br>
            <tr>
                <td colspan="2"><p style="text-align: center; font-weight: bold; font-size: 11px;">Expediente:&nbsp;&nbsp;&nbsp;<strong>'.$expediente.'&nbsp;&nbsp;</strong><br><br> Documento:&nbsp;&nbsp;&nbsp;<b>'.$providencia.'</b></p></td>
            </tr>
            
            <tr>
                <td colspan="2">                                    
                <p><strong><h1><b>TIPO DE PAGO  05</b></h1></strong></p>                                    
                </td>                                    
            </tr>
            <tr>
                <td colspan="2">                                    
                <p><strong><h1><b>Monto Q. 50.00 </b></h1></strong></p>                                    
                </td>                                    
            </tr>
            <tr>
                <td colspan="2">                                    
                    <p><strong><h1>NOTIFICACION CONTRATO DE ADHESION	</h1></strong></p>                                    
                </td>                                    
            </tr>
            <tr>
            <td colspan="2">                                    
                    <p><strong>'.$notificacion.'	</strong></p>                                    
            </td>                                    
            </tr>
            
            
            </tbody>
            </table>
            <br>  
            <br>         
            <img src="'.$svg_.'" alt="QR Code">                  
            <br>            
            <p>UUID: '. $qrCode.'</p>  
            <br>
            <p>
            '.$user.'&nbsp;'.$currentDateTime.'    
            </p>
            </div> 
            </body>
            </html>
            ';


            $pdf = PDF::loadHTML($html);
            $pdf->setPaper("a4", "portrait");
            
            $path = public_path('/upload');   
            $date = date('Y_m_d_H_i_s');      
            $fileName =  'NOTIFICACION_'.$date.'_'.$qrCode.'.'.'pdf' ;   
            $pdf->save($path . '/' . $fileName);
            
            $url = asset($path . '/' . $fileName);

            
                                
            Registro::create(
                [
                    'expediente' => $expediente, 
                    //'archivo' => $fileName, 
                    'uuid' => $qrCode, 
                    'documento' => 'ORDEN_PAGO', 
                    'dictamen' => $providencia,
                    'referencia' => auth()->id(), 
                    'estado' => 'ORDEN_PAGO', 
                    'comentario' => 'En revisión',                                            
                    'periodo' => $periodo
                ]
            );  
            $query = Solicitud::where('expediente',$expediente)->first();                            
            $email = $query->correoElectronico;


            
            $Actualizar = Solicitud::findOrFail($id);            
            $status = "ORDEN_PAGO";
            $Actualizar->status = $status;                
            $Actualizar->save();
            
            $data["email"]=$email;            
            $data["file"]=$path . '/' . $fileName;            
            $data["exp"]=$expediente;            
            
            Mail::send('notificacion.banrural_pagocontrato',$data, function($message)use($data) {
                $message->to($data["email"], $name = null);                    
                $message->subject("Sistema de control de expedientes ".$data["exp"]);                    
                $message->attach($data["file"]);
                $message->getSwiftMessage();                    
            });
            $idx = ($id * 211) + 1;
            //previoPagoMail::dispatch($email,$idx,900);                        

            $rx = [
                'code' => '200',            
                //'nombre_archivo' => $fileName
                'nombre_archivo' => $expediente
            ];                                   
            return $rx;
        }




    if($evento == 9){
        $rx = '300';
        $datosSolicitud = $request;
        $evento = $datosSolicitud['evento_id'];
        $expediente = $datosSolicitud['expediente'];
        $comentario = $datosSolicitud['comentario'];
        //return $datosSolicitud;
            $periodo =  date("Y");
            $ctn_expedientes = 0;
            $uuid  = Uuid::generate()->string;
            $documento = "";

            $query = Solicitud::where('expediente',$datosSolicitud['expediente'])->first();                
            $id = $query->id;
            $usuario = $query->user_id;
            
            $nombre = $query->nombreCompleto;        
            $propietario = $nombre;
            $razonSocial = $query->razonSocial;
            $tipo_propietario = $query->profesion;
            $direccionEstablecimiento = $query->direccion;
            $mpt = $query->municipio;
            $dpt = $query->departamento;

            $nombreDepartamento = Departamento::where('id', $dpt)->first();
            $eldepartamento = $nombreDepartamento->nombre;

            $nombreMunicipio = Municipio::where('id', $mpt)->first();
            $elmunicipio = $nombreMunicipio->nombre;
            
            $query = Evento::where('id',$datosSolicitud['evento_id'])->first();                
            $status = $query->categoria;
            $comentarioBitacora = $query->descripcion;
            



            $establecimiento = $query->nombre_Establecimiento;
            //$resultados = TuModelo::selectRaw('YEAR(created_at) AS anio')->get();

            $ctn_expedientes = Registro::where('documento', 'LIKE', 'CA-%')->where('periodo', '=', $periodo)->count();
            $ctn_resoluciones = Registro::where('dictamen', 'LIKE', 'DDC-%')->where('periodo', '=', $periodo)->count();
            $ctn_expedientes = $ctn_expedientes + 1;   
            $ctn_resoluciones = $ctn_resoluciones +1;
            $entidad_propietaria = "";
            $folio = 0;

            $folioMayor = 0;
            $folioMenor = 0;
            $ctnFolio = 0;
            try {
                $maximo = Registro::max('recibo');
                $t=0;                                                
                if ($maximo === null) {
                    $t = 0;
                }else{
                    $t = intval($maximo);
                }               
                $nuevoValor = intval($comentario);                        
                $acumulador = $t + $nuevoValor;
                $folio = strval($acumulador);
                $folioMayor = $acumulador;
                $folioMenor = ($folioMayor - $t) + 1;
                $cntFolio = $folioMayor - $folioMenor;
            } catch (\Exception $e) {
                $mensajeExcepcion = $e->getMessage();
                $rx = [
                    'code' => '300',            
                    'mensaje' => $mensajeExcepcion
                ];   
                
                return response()->json($rx);
            }

            if($tipo_propietario == 'Juridico'){
                $entidad = $razonSocial.' , entidad propietaria ';
            }else{
                $entidad = $propietario." , propietario ";
            }
            

            //$providencia = 'CA-'.$ctn_expedientes.'-'.$periodo;                                     
            $providencia = $expediente;
            $documento = 'DDC-'.$ctn_resoluciones.'-'.$periodo;                                     
            $ahora = date("Y-m-d H:i:s");
            
            $vencimiento = date('Y-m-d', strtotime($ahora. ' + 5 days'));
            /*Previo::create(
                [
                    'observaciones'=>$comentario,
                    'previo'=>$providencia,
                    'expediente' => $expediente, 
                    'user_id' => auth()->id(), 
                    'estado' => 'RESOLUCION', 
                    'numeroDocumento' => $documento,
                    'fechahoraRegistro' => $ahora , 
                    'fechahoraVencimiento' => $vencimiento,
                    'flag' => $folio,
                ]
            );*/    

        $ext = ".svg";        
        $qrCode  = Uuid::generate()->string;
        //$qr_certificacion = 'pdf/'.$qrCode.'.pdf';
        $qr_certificacion = $qrCode.'.pdf';
        


        //$url = env("URL_SISTEMA");  
        $url = 'https://www.diacoenlinea.net/certificaciones?qr=';
        QrCode::generate($url.$qrCode.'&t=res', public_path('/img/qr/'.$qrCode.$ext));       

        $pdf = App::make('dompdf.wrapper');         
        $svg_ = 'img/qr'.'/'.$qrCode.$ext;        
        $logo_ = 'img/logo.png'; 
        $firma_ = 'img/firma.png'; 

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
        $fechaFinal = $dia." DE ".$mes.' DEL AÑO '.$proximoanio;
        
        $currentDateTime = date('Y-m-d H:i:s');
        $user = Auth::user()->name;
                        

        //$pdf = \PDF::loadView('vista-pdf', $data);
        //$pdf = $pdf->loadView('resoluciones.res_a_nuevo', compact('store'));
        
        //$pdf = $pdf->loadView('resoluciones.res_a_nuevo', $data);

        $html = '
        <html>
        <head>
        <title>Resolución Expediente: '.$expediente.'</title>
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
        <div> 
        <table>
        <tbody>

        

        <tr>
            <td colspan="2"><img src="'.$logo_.'" width="300" height="90" alt="Logo"></td>
        </tr>
        
        <tr>
            <td colspan="2"><p style="text-align: center; font-weight: bold; font-size: 11px;">Expediente:&nbsp;&nbsp;&nbsp;<strong>'.$expediente.'&nbsp;&nbsp;</strong></p></td>
        </tr>
        
        <tr style="text-align: center;">
        <td colspan="2">
            <div style="text-align: center;">
                <p>DIRECCIÓN DE ATENCIÓN Y ASISTENCIA AL CONSUMIDOR <br>
                MINISTERIO DE ECONOMÍA <br>
                RESOLUCIÓN '.$documento.' 
                GUATEMALA, '.$fechaInicial.'</p>
            </div>
        </td>
        </tr>
    

        <tr>
        <td colspan="2">&nbsp;&nbsp;
            <p>Se tiene a la vista para resolver el expediente administrativo identificado como '.$providencia.', que contiene solicitud de aprobación y registro del contrato de adhesión presentado por el proveedor '.$entidad.'  del centro educativo '.$establecimiento.', ubicado en '.$direccionEstablecimiento.', departamento '.$eldepartamento.'.</p>
       </td>
        </tr>
        
        <tr>
            <td  colspan="2">&nbsp;&nbsp;
            <p style="text-align: center; font-weight: bold; font-size: 11px; "><strong>CONSIDERANDO:</strong></p>
            <p>Que de conformidad a lo normado en los Artículos 52 de la Ley de Protección al Consumidor y Usuario y 33 de su Reglamento, los proveedores en los contratos de adhesión deberán enviar copia de este a la Dirección de Atención y Asistencia al Consumidor, para su aprobación y registro cuando cumplan con las leyes del país en su normativa..</p>
            </td>
        </tr>


        <tr>
        <td colspan="2">&nbsp;&nbsp;
        <p style="text-align: center; font-weight: bold; font-size: 11px; "><strong>CONSIDERANDO:</strong></p>
        <p>Que visto el modelo de contrato de adhesión, presentado por el proveedor '.$entidad.' del centro educativo '.$establecimiento.' habiendo realizado el análisis jurídico correspondiente, se determina que cumple con lo establecido en la Ley y Reglamento de Protección al Consumidor y Usuario, sin perjuicio de la obligación del cumplimiento de los requisitos legales que correspondan para el desarrollo de su actividad educativa.</p>
        </td>
        </tr>
        <tr>
        <td colspan="2">&nbsp;&nbsp;
        <p style="text-align: center; font-weight: bold; font-size: 11px;"><strong>POR TANTO:</strong></p>
        <p>Con base en lo considerado y con fundamento en el Artículo 54 inciso r) de la Ley de Protección al Consumidor y Usuario; esta Dirección:</p>
        </td>
        </tr>
        <tr>
        <td colspan="2">
        <br>
        <p style="text-align: center; font-weight: bold; font-size: 11px;"><strong>RESUELVE:</strong></p>
        
        </td>
        </tr>

        <tr>
            
            <td colspan="2">
            <br><p>I)	Aprobar y Registrar el contrato de adhesión, presentado por el proveedor '.$entidad.' del centro educativo '.$establecimiento.' ubicado en '.$direccionEstablecimiento.' del municipio de '.$elmunicipio.', departamento de '.$eldepartamento.' el cual queda inscrito en el Registro: '.$folio.' Folio: '.$folio.', Libro Único del Registro Público de Contratos de Adhesión de esta Dirección, por lo que el proveedor deberá hacer constar en todos los formatos del contrato registrado, el número de la presente resolución. 
            </p>
            </td>
        </tr>

        <tr>
            
            <td colspan="2"><br><p>II)	El formato, texto y tamaño de letra del modelo de contrato de adhesión registrado, consta en '.$cntFolio.' hojas, impresas únicamente en su lado anverso y obra a folios del '.$folioMayor.' al '.$folioMenor.' del expediente de mérito.
        </p></td>
        </tr>
        
        <tr>
        
        <td colspan="2"><br><p> III)	Cualquier modificación al texto del modelo de contrato de adhesión registrado, deberá solicitarse por escrito a esta Dirección y adjuntar la documentación de soporte para dicho cambio.   </p></td>
        <br>  
        </tr>

        <tr>
        
        <td colspan="2"><br><p> IV)	La aprobación del presente contrato no limita la facultad de esta Dirección para revisar en cualquier momento lo estipulado en el mismo y en caso de considerarse necesario se podrá revocar de oficio.   </p></td>
        <br>  
        </tr>
        
        <tr>        
        <td colspan="2"><br><p> V)	Esta Dirección se exime de responsabilidad por incumplimiento del proveedor relacionado con leyes penales, civiles y administrativas o de cualquier otra índole, en virtud que el cumplimiento del presente contrato es estricta responsabilidad del proveedor obligado.   </p></td>
        <br>  
        </tr>
        
        <tr>        
        <td colspan="2"><br><p>  VI)	Finalizar el trámite administrativo del expediente identificado en el acápite.  </p></td>
        <br>  
        </tr>
        
        <tr>        
        <td colspan="2"><br><p> VII)	Notifíquese.   </p></td>
        <br>  
        </tr>
        
        <tr>
        
        <td colspan="2"><br><p>   Cita legal: Artículos: 1 al 4, 14 al 16, 30, 47 al 52 de la Ley de Protección al Consumidor y Usuario; 1, 2 y 33 de su Reglamento.  </p></td>

        </tr>
                                                                                
        </tbody>
        </table>
                    <table>
                    <tbody>
                    <tr>
                        <td>
                                <img src="'.$svg_.'" alt="QR Code" width="60" height="60">                
<<<<<<< HEAD
                                <br>            
                                <p>UUID: '. $qrCode.'</p>  
                        </td>                        
                        <td>
                                <img src="'.$firma_.'" width="60" height="30" alt="firma">                                
                                <p>
                                '.$user.'&nbsp;'.$currentDateTime.'    
                                </p>
=======
                                <br>              
                        </td>                        
                        <td>
                                
>>>>>>> a6d14650e684b4ee169f5fc59ad3ee668d95ec5f
                        </td>
                    </tr>
                    </tbody>
                    </table>                
        </div> 
        </body>
        </html>
        ';
        
        

        $pdf = PDF::loadHTML($html);
        //$pdf->setPaper("a4", "portrait");
        $pdf->setPaper([0, 0, 612, 792], 'portrait');

        
        $path = public_path('/upload');   
        $date = date('Y_m_d_H_i_s');      
        $fileName =  'RESOLUCION '.$expediente.'-'.$date.'_'.$qrCode.'.'.'pdf' ;   
        $pdf->save($path . '/' . $fileName);

        /* INICIO CARGAR ARCHIVO API*/

        $file_ = fopen($path . '/' . $fileName, "r+");

        Http::attach(
            'file', $file_
        )->post("http://localhost:3001/api/doc/cargar/archivo", [
            'adjunto' => 64, // Pendiente de revisar
            'expediente' => $expediente,
            'descripcion' => 'Resolucion'.$expediente.'-'.$date.'_'.$qrCode,
        ]);

        unlink($path . '/' . $fileName);
        
        /* FINAL CARGAR ARCHIVO API*/

        //$emailreceptor = $ticket->email;
        
        // Descargar el archivo PDF
        //return $pdf->download($fileName);
        $url = asset($path . '/' . $fileName);
                              
            Registro::create(
                [
                    'expediente' => $expediente, 
                    'archivo' => $fileName, 
                    'uuid' => $qrCode, 
                    'documento' => $providencia, 
                    'dictamen' => $documento,
                    'referencia' => auth()->id(), 
                    'estado' => 'RESOLUCION', 
                    'comentario' => $comentario,                                            
                    'periodo' => $periodo,
                    'recibo' => $folio
                ]
            );  
            
            $query = Solicitud::where('expediente',$expediente)->first();   
            
            $id = $query->id;
            
            $email = $query->correoElectronico;
            $analista = $query->analista_id;
            $query2 = User::where('id',$analista)->first();                
            $email_analista = $query2->email;

                        
            $Actualizar = Solicitud::findOrFail($id);            
            $status = "RESOLUCION";
            $Actualizar->status = $status;                
            $Actualizar->save();


            //previoPagoMail::dispatch($email,$path.$fileName,701);            


            Requisito::create(
                ['tipo'=> 'Resolución','descripcion' => 'Archivo de resolución contrato de adhesion', 'archivo' => $fileName, 'expediente' => $expediente, 'user_id' =>auth()->id() ]
            );      
                                               

            $notificacionx = " Resolucion emitida pendiente de aprobación";
            $d = $expediente.'-'.$notificacionx;
            previoPagoMail::dispatch($email, $d, 903);
            previoPagoMail::dispatch($email_analista, $d, 903);

                                    
            $rx = [
                'code' => '200',            
                'nombre_archivo' => $fileName
            ];           
                    
            return $rx;       
        }
    }

    public function firmarArchivo($nombre_archivo)
    {
        #$nombre_archivo = "prueba_firmae";

        $this->mover_documento_servidor_firma($nombre_archivo);
        
        $data['script'] = "
            function FirmarPdf(){
                var path_pdf_in = '\\\\\\\\172.17.10.60\\\\inetpub\\\\wwwroot\\\\FirmaeExtensiones\\\\Pdfs\\\\'".$nombre_archivo."'U.pdf';
                var path_pdf_out = '\\\\\\\\172.17.10.60\\\\inetpub\\\\wwwroot\\\\FirmaeExtensiones\\\\Pdfs\\\\'".$nombre_archivo."'.pdf';
                var imagen = null;
                var razon = 'razon'; 
                var ubicacion = 'ubicacion';
                var coordenadas = '60,200,300,250,1';
                var certificado = '0'; 
                var webserviceURL = 'https://firmae.mintrabajo.gob.gt';
                var SolicitarCertificado = 'true';
                FirmarExtension(path_pdf_in, path_pdf_out, razon, ubicacion, imagen, coordenadas, certificado, webserviceURL, SolicitarCertificado);
            }

            function FirmarExtension(path_pdf_in, path_pdf_out, razon, ubicacion, imagen, coordenadas, certificado, webserviceURL, SolicitarCertificado){
                var Envio = new Object; 
                Envio.path_pdf_in = path_pdf_in; 
                Envio.path_pdf_out = path_pdf_out; 
                Envio.imagen = imagen; 
                Envio.razon = razon; 
                Envio.ubicacion = ubicacion; 
                Envio.coordenadas = coordenadas; 
                Envio.certificado = certificado; 
                Envio.webservice = webserviceURL;
                Envio.SolicitarCertificado = SolicitarCertificado;
                
                var evento = document.createEvent('CustomEvent');
                evento.initCustomEvent('addon-message-firmae', true, true, Envio); 
                document.documentElement.dispatchEvent(evento);
            }

            function FindAddOnExtension() { 
                var Error = document.getElementById('hideError').value; 
                var Descripcion = document.getElementById('hideDescripcion').value; 
                Respuesta(Error, Descripcion); 
            }
    
            function Respuesta(CodigoError, Descripcion) { 
                alert('Codigo de Error: ' + CodigoError + ' : ' + Descripcion); 
            }
        ";
        
        $this->traer_documento_servidor_firma("documento");
        //return view("welcome", $data);
    }

    public function mover_documento_servidor_firma($nombre_archivo,$local)
    {
        #$local = public_path()."\\pdfs\\".$nombre_archivo.".pdf"; //ruta del archivo local        
        $remoto = '\\\\172.17.10.60\\inetpub\\wwwroot\\FirmaeExtensiones\\Pdfs\\'.$nombre_archivo.'U.pdf'; //ruta del archivo remoto a donde se va copiar
        
        $file = fopen ($local, "rb");
        if ($file) {
            $newf = fopen ($remoto, "a");
            if ($newf)
            while(!feof($file)) {
                fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
            }
        }
        if ($file) {
            fclose($file);
        }
        if ($newf) {
            fclose($newf);
        }
        unlink($local); //borra el archivo del local
    }

    public function traer_documento_servidor_firma($nombre_archivoe, $local)
    {
        #$local = public_path()."\\pdfs\\".$nombre_archivoe.".pdf"; //ruta del archivo local donde se recuperar el archivo ya firmado
        $remoto = '\\\\172.17.10.60\\inetpub\\wwwroot\\FirmaeExtensiones\\Pdfs\\'.$nombre_archivoe.'.pdf'; // ruta del archivo a donde se consultara el archivo firmado
        
        $file = fopen ($remoto, "rb");
        if ($file) {
            $newf = fopen ($local, "a");
            if ($newf)
            while(!feof($file)) {
                fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
            }
        }
        if ($file) {
            fclose($file);
        }
        if ($newf) {
            fclose($newf);
        }
        $archivo_subido = '\\\\172.17.10.60\\inetpub\\wwwroot\\FirmaeExtensiones\\Pdfs\\'.$nombre_archivoe.'U.pdf';
        unlink($archivo_subido); //borra el archivo del servidor subido sin firma
        clearstatcache();
        unlink($remoto); //borra el archivo del servidor subido con firma
    }

    public function obtenerListado(Request $request)
    {        
        //return Evento::where('tipo',$request['status'])->orderBy('id', 'ASC')->get();    
        return Evento::where('tipo',$request['status'])->orderBy('id', 'ASC')->get();    
    }

    public function obtenerBitacora(Request $request){
        $datosSolicitud = $request;
        return Registro::where('expediente',$datosSolicitud['expediente'])->orderBy('id', 'DESC')->get();   
    }


    public function obtenerUltimo(Request $request){
        $datosSolicitud = $request;
        return Registro::join(DB::raw('(SELECT expediente, MAX(updated_at) fecha_movimiento
        FROM `registros` GROUP BY expediente)
        UlmimoMovimiento'), 
        function($join)
        {
            $join->on('registros.updated_at', '=', 'UlmimoMovimiento.fecha_movimiento');
        })->where('registros.expediente',$datosSolicitud['codigoEmpresa'])->orderBy('updated_at', 'DESC')->get();   
    }

    public function actualizar_backup(Request $request){
        $rx = '300';
        $datosSolicitud = $request;
        $expediente = $datosSolicitud['expediente'];
        $periodo =  date("Y");
        $ctn_expedientes = 0;
        $uuid  = Uuid::generate()->string;
        $documento = "";

        $query = Solicitud::where('expediente',$datosSolicitud['expediente'])->first();                
        $id = $query->id;
        $usuario = $query->user_id;
        
        $nombre = $query->nombreCompleto;
        $nacionalidad = $query->nacionalidad;
        $idempresa = $query->codigoEmpresa;
        $razonSocial = $query->razonSocial;
        $nombrePlaza = $query->nombrePlaza;

       
        $query2 = User::where('id',$usuario)->first();
        $email = $query2->email;

        $query = Evento::where('id',$datosSolicitud['evento_id'])->first();                
        $status = $query->categoria;
        $comentarioBitacora = $query->descripcion;


        $queryTipoAdjunto = Adjunto::where('descripcion','Previo')->first();
        $idPrevio = $queryTipoAdjunto->id;
        //$idPrevio = "Previo";
        //$idPrevio = $datosSolicitud['evento_id'];

        $queryTipoAdjunto = Adjunto::where('descripcion','Resolucion')->first();
        $idResolucion = $queryTipoAdjunto->id;

        $Actualizar = Solicitud::findOrFail($id);            
        $Actualizar->status = $status;        
        $Actualizar->save();

//6bolsa
//7pago
//8Tramite
        $codigoDocumento ="";
        $textoPrevio = "";
        $flagPrevio = false;
        if($datosSolicitud['evento_id']==6){
            $textoPrevio = "Atentamente, pase al Director General de Empleo, para que se sirva girar instrucciones a donde corresponda a fin de constatar si en Guatemala, se cuenta con personal técnico capacitado en las ramas. Vuelva la presente diligencia.";
            $codigoDocumento = "PTE-FO-10-2";
            $flagPrevio = true;
        } 
        if($datosSolicitud['evento_id']==7){
            $codigoDocumento = "";
            $textoPrevio = "Director, Dirección General de Empleo, previo a emitir la resolución correspondiente, que la entidad interesada en contratar los servicios del(de la) señor(a) ".$nombre." cumpla con presentar dentro del plazo de cinco dias lo siguiente según lo establece en el artículo 6 del Acuerdo Gubernativo 528-2003 Reglamento de Autorización del Trabajo de Personas Extranjeras a Empleadores del Sector Privado. Notifíquese.  a) Capacitación indirecta. (Si cancela con cheque, el cheque de caja a nombre de SECAFOR, debe presentar comprobante de pago con respectiva fotocopia para confronte, de no comprobar el pago la solicitud se rechazará).";
            $flagPrevio = true;
        } 
        if($datosSolicitud['evento_id']==8)
        { 
            $codigoDocumento = "PTE-FO-6-2";
            $textoPrevio = "Director, Dirección General de Empleo, previo a emitir la resolución correspondiente, que la entidad interesada en contratar los servicios del(de la) señor(a) ".$nombre." cumpla con presentar dentro del plazo de cinco dias lo siguiente según lo establece en el artículo 6 del Acuerdo Gubernativo 528-2003 Reglamento de Autorización del Trabajo de Personas Extranjeras a Empleadores del Sector Privado. Notifíquese.  ".$datosSolicitud['comentario'];
            $flagPrevio = true;
        }

        if($datosSolicitud['evento_id'] == 2){
        Registro::create(
            [
                'expediente' => $expediente,                                 
                'documento' => 'Jefapex',                 
                'referencia' => auth()->id(), 
                'estado' => 'REVISION', 
                'comentario' => 'Visto Bueno PEX'                
            ]
        );  
        }

        /*
        if($datosSolicitud['evento_id'] == 5){
            Registro::create(
                [
                    'expediente' => $expediente,                                 
                    'documento' => 'Dirección',                 
                    'referencia' => auth()->id(), 
                    'estado' => 'FIRMAELECTRONICA', 
                    'comentario' => 'Documento Firmado'                
                ]
             );  
        }
        */
                          
       
        if ($datosSolicitud['evento_id'] == 7 || $datosSolicitud['evento_id'] == 8){            
            previoPagoMail::dispatch($email,$nombre,$datosSolicitud['evento_id']);            
        }

        $rx = [
            'code' => '200',            
            'nombre_archivo' => 'QRFile'
        ];           
                
        return $rx;
    }


    public function selector($data){
    } 

}



