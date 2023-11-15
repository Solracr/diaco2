<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use File;
use Mail;
use App\Jobs\previoPagoMail;

use App\Models\Requisito;
use App\Models\Evento;
use App\Models\Solicitud;
// Moldelos API
use App\Models\Archivo;
// Consumir API
use Illuminate\Support\Facades\Http;


class FirmaController extends Controller
{
    public function firmar(Request $request){                     
        $datosSolicitud = $request;
        $expediente = $datosSolicitud['expediente'];

        $resultRegistro = Registro::where('expediente','=', $expediente)
                                    ->where('documento','=','resolucion')
                                    ->first();
        $archivo = $resultRegistro->uuid;
        $l = $resultRegistro->archivo;             
        $local = public_path()."/upload/".$l; //ruta del archivo local                
        $cmd = "";

        // File::copy('C:\\xampp\\htdocs\\masterfile\\public\\upload'.'/'.$archivo.'.pdf','/home/disi/firma2/'.$archivo.'U.pdf');
     
        $rx = [
            'code' => 200,
            'payload' => $archivo,
            'result'=>$cmd,                        
            'archivo' => $archivo            
        ];           
        
        return $rx;                               
    }


    public function closeFile(Request $request){
        $query = Evento::where('id',5)->first();                
        $status = $query->categoria;
        

        $Actualizar = Solicitud::findOrFail($id);            
        $Actualizar->status = $status;        
        $Actualizar->save();


        $datosSolicitud = $request;
        $expediente = $datosSolicitud['expediente'];
        Registro::create(
            [
                'expediente' => $expediente,                                 
                'documento' => 'Dirección',                 
                'referencia' => auth()->id(), 
                'estado' => 'FIRMAELECTRONICA', 
                'comentario' => 'Documento Firmado'                
            ]
         );  
         return "Actualizacion ".$expediente." --> ".$status;
    }


    public function rechazar(Request $request){
        $datosSolicitud = $request;
        $expediente = $datosSolicitud['expediente'];
        $query = Solicitud::where('expediente',$expediente)->first();                                                  
        $query->status = 'RECHAZADO';        
        $query->save();

        
         return "Rechazo ".$expediente." --> ".$status;
    }


    public function restaurarFirma(Request $request){
        $datosSolicitud = $request;       
        $archivo = $datosSolicitud['archivo'];                        
        $local = public_path()."/upload/".$datosSolicitud['archivo']; //ruta del archivo local                
        $cmd = "";
        File::copy('/home/disi/firma2/'.$archivo.'.pdf','/var/www/html/qapex/public/upload'.'/'.$datosSolicitud['archivo'].'.pdf');
        $file ='/upload'.'/'.$datosSolicitud['archivo'].'.pdf';
        
        /*--------------------*/         
        $resultRegistro = Registro::where('uuid','=', $datosSolicitud['archivo'])->first();        
        $expediente = $resultRegistro->expediente;

        $resultSolicitud = Solicitud::where('expediente','=', $expediente)->first();
        $usuario = $resultSolicitud->user_id;
                
        $resultUsuario = User::where('id',$usuario)->first();        
        $email = $resultUsuario->email;        
        $nombre = $resultSolicitud->nombreCompleto;        
        
        $data["email"]=$email;            
        $data["file"]=$file;            
        
        Mail::send('notificacion.notificacionResolucion',$data, function($message)use($data) {
            $message->to($data["email"], $name = null);
            $message->subject("Sistema de Control de Expedientes - RESOLUCION -");            
            $message->attach($data["file"]);                                                
            $message->getSwiftMessage();                  
         });
        
        /*seccion de notificacion*/
            /*$resultRegistro = Registro::where('uuid','=', $datosSolicitud['archivo'])->first();
            $expediente = $resultRegistro->expediente;
            $resultSolicitud = Solicitud::where('expediente','=', $expediente)->first();
            $email = $resultSolicitud->correoElectronico;
            $nombre = $resultSolicitud->nombreCompleto;        
            previoPagoMail::dispatch($email,$nombre,300,$file);*/
        /*fin de la seccion de notificacion*/
        

        $rx = [
            'code' => 200,
            'payload' => $archivo                                   
        ];                   
        return $rx;                               
    }


    public function testMail(Request $request){
        $datosSolicitud = $request;       
        $expediente = $datosSolicitud['archivo'];                        
                                 
        /*--------------------*/         
        $resultRegistro = Registro::where('expediente','=', $datosSolicitud['archivo'])
                                    ->where('referencia','=','2')->first();        
        $fileUUID = $resultRegistro->uuid;

        

        $local = public_path()."/upload/".$fileUUID; //ruta del archivo local                
        $cmd = "";

        $resultSolicitud = Solicitud::where('expediente','=', $expediente)->first();
        $usuario = $resultSolicitud->user_id;
                
        $resultUsuario = User::where('id',$usuario)->first();        
        $email = $resultUsuario->email;        
        $nombre = $resultSolicitud->nombreCompleto;        
        
        $data["email"]=$email;            
        $data["file"]=$local.'.pdf';            
        
        Mail::send('notificacion.notificacionBolsa',$data, function($message)use($data) {
            $message->to($data["email"], $name = null);
            $message->subject("RESOLUCION - Sistema de Contratos de Adhesion");            
            $message->attach($data["file"]);                                                
            $message->getSwiftMessage();                  
         });
        
        $rx = [
            'code' => 200,
            'payload' => $local.'.pdf'                                   
        ];                   
        return $rx;                               
    }


    public function mover_documento_servidor_firma($nombre_archivo,$local)
    {        
        $remoto = '/home/disi/firma2/'.$nombre_archivo.'U.pdf'; //ruta del archivo remoto a donde se va copiar     

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

    public function traer_documento_servidor_firma($nombre_archivo, $local)
    {
        $remoto = '/home/disi/firma2/'.$nombre_archivo.'.pdf'; //ruta del archivo remoto a donde se va copiar
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
        #$archivo_subido = '\\\\172.17.10.60\\inetpub\\wwwroot\\FirmaeExtensiones\\Pdfs\\'.$nombre_archivoe.'U.pdf';
        $archivo_subido = '/home/disi/firma2/'.$nombre_archivo.'U.pdf';
        unlink($archivo_subido); //borra el archivo del servidor subido sin firma
        clearstatcache();
        unlink($remoto); //borra el archivo del servidor subido con firma
    }

    // API DOCUMENTOS

    public function actualizarDocFirmado(Request $request)
    {
        $response = Http::attach(
            'file', $request->file('file')->getPathname()
        )->put("http://localhost:3001/api/doc/actualizar/archivo/firmado/", [
            'expediente' => $request->expediente,
            'adjunto' => 64, // Pendiente de confirmar
            'tipo' => $request->file('file')->getClientMimeType()
        ]); 

        return $response;
    }

    public function visualizarDocFirmado(Request $request)
    {
        $response = Http::get('http://localhost:3001/api/doc/descargar/archivo/'.$request->doc.'/'.$request->expediente.'?tipo='.$request->ext);

        return $response;
    }
}


   //sleep(3);
        //File::copy('/home/disi/firma2/'.$archivo.'U.pdf','/var/www/html/qapex/public/upload'.'/'.$archivo.'.pdf');
                        

        //forma 5.1
        //Storage::copy('//var//www//html//qapex//public//upload'.'//'.$archivo.'.pdf', '//home//disi//Pdfs//'.$archivo.'U.pdf');
        
        //Storage::copy('public/upload/'.$archivo.'.pdf', '/home/disi/Pdfs/'.$archivo.'U.pdf');        
//robots.txt

        /*$filename = 'tempFile.pdf';
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        copy('https://qapex.mintrabajo.gob.gt/upload/4428a410-4eeb-11ec-93a5-3b5229d10e5b.pdf', $tempImage);
        
        $filename = 'tempFile.pdf';
        $tempImage = tempnam('/home/disi/Pdfs/', $filename);
        copy('https://qapex.mintrabajo.gob.gt/upload/4428a410-4eeb-11ec-93a5-3b5229d10e5b.pdf', $tempImage);
        */
        //forma 6        
        /*$source = '/var/www/html/qapex/public/upload'.'/'.$archivo.'.pdf';                 
        $destination = '/home/disi/Pdfs/'.$archivo.'U.pdf'; 
        
        try {
            $copyresult = "";
                if( !copy($source, $destination) ) { 
                    $copyresult =  "File can't be copied!"; 
                } 
                else { 
                    $copyresult =  "File has been copied!"; 
                }
        } catch (ModelNotFoundException $exception) {
            $copyresult = $exception->getMessage()->withInput();
        }*/
        
         
        /*$original = Storage::get('//var//www//html//qapex//public//upload'.'//'.$archivo.'.pdf');
        Storage::disk('home')->put($archivo.'U.pdf', $original); */

        //forma 1
        //$this->mover_documento_servidor_firma($archivo,$local); 
        //$this->traer_documento_servidor_firma($archivo,$local);   

        //forma 2

        /*$original = Storage::post(public_path().'/upload/'.$l);
        Storage::disk('home')->put('/home/disi/Pdfs/'.$archivo.'U.pdf', $original); 

        $remoto = Storage::disk('home')->get('/home/disi/Pdfs/'.$archivo.'U.pdf');
        Storage::disk('local')->put($remoto, $original); 


       


        $process = new Process(['mv', '/var/www/html/qapex/public/upload'.'/'.$archivo.'.pdf']);
        $process - > run();*/

        //forma 3
        /*Storage::move('/var/www/html/qapex/public/upload'.'/'.$archivo.'.pdf', '/home/disi/Pdfs/'.$archivo.'U.pdf');
        Storage::move('/home/disi/Pdfs/'.$archivo.'.pdf','/var/www/html/qapex/public/upload'.'/'.$archivo.'.pdf');*/


        
        //forma 4
        /*        
        File::move('/var/www/html/qapex/public/upload'.'/'.$archivo.'.pdf','/home/disi/Pdfs/'.$archivo.'U.pdf');
        File::move('/home/disi/Pdfs/'.$archivo.'U.pdf', '/var/www/html/qapex/public/upload'.'/'.$archivo.'.pdf');
        */

        /*
        $process = new Process(['mv', '/var/www/html/qapex/public/upload'.'/'.$archivo.'.pdf', '/home/disi/Pdfs/']);
        $process -> run();
        */

        /*
        $cmd = 'cp //var//www//html//qapex//public//upload'.'//'.$archivo.'.pdf //home//disi//pdfs2//'.$archivo.'U.pdf';
        exec($cmd, $result, $var);

        
        $cmd = 'cp /var/www/html/qapex/public/upload'.'/'.$archivo.'.pdf /home/disi/pdfs2/'.$archivo.'U.pdf';
        exec($cmd, $result, $var);
        */
        
        
        //fel kali
        //firma electronica