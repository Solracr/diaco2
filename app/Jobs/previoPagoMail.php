<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Mail;
use Uuid;
use PDF;
use App;



class previoPagoMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email = null;
    private $nombre = null;
    private $selector = null;
    private $pdf = null;
    
    
    public function __construct($email,$nombre,$selector)    
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->selector = $selector;        
        
    }

    public function handle()
    {
        $data["email"]=$this->email;
        //$texto=selector($this->selector);        
        $data["client_name"]=$this->nombre;
        $data["subject"]='Notificación Sistema de Control de Gestiones';
        

        try{

            if($this->selector == 900){                
                Mail::send('notificacion.notificacionContrato', $data, function($message)use($data) {
                        $message->to($data["email"], $data["client_name"])
                        ->subject("Notificación de Contrato de Adhesión - Observaciones -  ");                    
                    });
            }       
            
            if($this->selector == 903){                
                Mail::send('notificacion.alert', $data, function($message)use($data) {
                        $message->to($data["email"], $data["client_name"])
                        ->subject("Notificación Contrato de Adhesión  ".$data["client_name"]);                    
                    });
            }       

            if($this->selector == 7){                
                    Mail::send('notificacion.notificacionPrevioPago', $data, function($message)use($data) {
                        $message->to($data["email"], $data["client_name"])
                        ->subject($data["subject"]);
                    });
            }

            if($this->selector == 8){
                Mail::send('notificacion.notificacionPrevioTramite', $data, function($message)use($data) {                    
                        $message->to($data["email"], $data["client_name"])
                        ->subject($data["subject"]);                        
                    });
            }
            
            if($this->selector == 500){
                Mail::send('notificacion.notificacionTicket', $data, function($message)use($data) {
                    //Mail::send($texto, $data, function($message)use($data) {
                    //$message->from($address = 'noreply@mintrabajo.gob.gt', $name = 'NOTIFICAICONES PEX')
                        $message->to($data["email"], $data["client_name"])
                        ->subject("Ticket No. ".$data["client_name"]." ".$data["subject"]);
                        //->attachData($pdf->output(), "notificacionPrevio.pdf");
                    });
            }

            if($this->selector == 501){                
                Mail::send('notificacion.ticketFinalizado', $data, function($message)use($data) {                    
                        $message->to($data["email"], $data["client_name"])
                        ->subject("Ticket Finalizado ".$data["client_name"]." ".$data["subject"]);                        
                    });
            }

      
            if($this->selector == 701){                
                Mail::send('notificacion.banrural_pagocontrato', $data, function($message)use($data) {                   
                    $message->to($data["email"], $data["client_name"])
                            ->subject("Previo de Pago ");                                
                    if(file_exists($data["client_name"])) {
                        $message->attach($data["client_name"]);
                    }
                });
            }
            

            
                if($this->selector == 100){                     
                        Mail::send('notificacion.notificacionRechazo', $data, function($message)use($data) {
                            $message->to($data["email"], $data["client_name"])
                            ->subject($data["subject"]);                        
                        });
                }

                if($this->selector == 200){
                    //Mail::send('notificacion.notificacionPrevioPago', $data, function($message)use($data,$pdf) {
                        Mail::send('notificacion.notificacionCertificacion', $data, function($message)use($data) {
                        //Mail::send($texto, $data, function($message)use($data) {
                        //$message->from($address = 'noreply@mintrabajo.gob.gt', $name = 'NOTIFICAICONES PEX')
                            $message->to($data["email"], $data["client_name"])
                            ->subject($data["subject"]);                          
                        });
                }

                
                if($this->selector == 202){ 
                    /*$this->pdf = App::make('dompdf.wrapper');       
                    $this->pdf->loadHTML($this->nombre);
                    $this->pdf->setPaper("a4", "portrait");  */
                    //$pdf = PDF::loadView('notificacion.notificacionBolsa', $data)->setPaper('a4');                                          
                    //Mail::send('emails.contact', $data, function($message) use ($data){
                    Mail::send('notificacion.notificacionBolsa',$data, function($message)use($data) {

                            //$message->from($address, $name = null);
                            //$message->sender($address, $name = null);
                            $message->to($data["email"], $name = null);
                            //$message->cc($address, $name = null);
                            //$message->bcc($address, $name = null);
                            //$message->replyTo($address, $name = null);
                            $message->subject($data["subject"]);
                            //$message->priority($level);
                            //$message->attach($pathToFile, array $options = []);
                            $message->attach($data["client_name"]);
                            
                            // Attach a file from a raw $data string...
                            //$message->attachData($data, $name, array $options = []);
                            
                            // Get the underlying SwiftMailer message instance...
                            $message->getSwiftMessage();
                            /*$message->to($data["email"], $data["client_name"])
                            ->subject($data["subject"]);*/

                        
                    });
                }
                

                if($this->selector == 300){
                    //Mail::send('notificacion.notificacionPrevioPago', $data, function($message)use($data,$pdf) {
                        Mail::send('notificacion.notificacionResolucion', $data, function($message)use($data) {
                        //Mail::send($texto, $data, function($message)use($data) {
                        //$message->from($address = 'noreply@mintrabajo.gob.gt', $name = 'NOTIFICAICONES PEX')
                            $message->to($data["email"], $data["client_name"])
                            ->subject($data["subject"]);
                            /*->attachData($this->file, 'RESOLUCION.pdf', [
                                'mime' => 'application/pdf',
                            ]);*/
                        });
                }

            
            
            
        }catch(JWTException $exception){
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
                $this->statusdesc  =   "Error sending mail";
                $this->statuscode  =   "0";
    
        }else{
    
            $this->statusdesc  =   "Message sent Succesfully";
            $this->statuscode  =   "1";
        }
        return response()->json(compact('this'));
    }


    public function selector($tipo){
        if ($tipo == 7){
            return '<html>
            <head>
                <style>
                    div {
                      background-color: rgb(189, 199, 202);
                      width: 100%;
                      padding: 5px;
                    }
                    </style>
             <title>Notificación Sistema de Control de Expedientes</title>
            </head>
            <body>                           
              <div> 
                  <h1>Departamento de Control de Expedientes</h1>
                    <strong><p>Se le hace de su conocimiento que su trámite se encuentra en estado de notificación de pago, al aceptar tendrá un plazo no más de 5 días hábiles para cumplir con su pago de lo contrario se rechazará el expediente.</p></strong>  
              </div>
            </body>
            </html> ';
        }

        if($tipo==8){
            return '<html>
            <head>
                <style>
                    div {
                      background-color: rgb(189, 199, 202);
                      width: 100%;
                      padding: 5px;
                    }
                    </style>
             <title>Notificación Sistema de Control de Expedientes</title>
            </head>
            <body>               
              <div> 
                  <h1>Departamento de Control de Expedientes</h1>
                    <strong><p>Se le hace de su conocimiento que su trámite se encuentra en estado de notificación de Previo de Tramite, al aceptar tendrá un plazo no más de 5 días hábiles para cumplir con lo solicitado de lo contrario se rechazará el expediente.</p></strong>  
              </div>
            </body>
            </html> ';
        }
    }
}
