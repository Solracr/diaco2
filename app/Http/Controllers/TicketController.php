<?php

namespace App\Http\Controllers;
use Uuid;
use App\Jobs\previoPagoMail;
use App\Models\it_ticket;
use Illuminate\Http\Request;

use PDF;
use QrCode;


class TicketController extends Controller
{
        //
    public function ticket_add(Request $request)
    {
        $datosSolicitud = $request;
        $email = $datosSolicitud['subject'];

        // Obtener el año actual
        $currentYear = date('Y');

        // Contar la cantidad de registros para el año actual
        $countForYear = it_ticket::where('registro', 'LIKE', "%{$currentYear}%")->count();

        // Generar el correlativo
        $correlativo = $countForYear + 1;

        $registro = "{$correlativo}-{$currentYear}";
        $usuario = $datosSolicitud['nombre'];
        $descripcion = $datosSolicitud['message'];
        $sede = $datosSolicitud['sede'];
        $departamento = $datosSolicitud['departamento'];
        $status = "EN PROCESO";

        //$correo_tecnico = "victor.1214@hotmail.com";
        previoPagoMail::dispatch($email, $registro, 500);
        //previoPagoMail::dispatch($correo_tecnico, "Nuevo Ticket Ingresado: ".$registro, 500);

        it_ticket::create(
            [
                'fecha' => date("Y-m-d H:i:s"),
                'registro' => $registro,
                'email' => $email,
                'usuario' => $usuario,
                'status' => $status,
                'descripcion' => $descripcion,
                'sede' => $sede,
                'departamento' => $departamento,
            ]
        );

        echo $registro;
    }



    /*public function listado_reporte_ticket()
    {            
        $it_tickets = it_ticket::orderBy('id', 'DESC')->get();        
        $it_tickets->each(function ($it_ticket) {
            $created_at = \Carbon\Carbon::parse($it_ticket->created_at);
            $updated_at = \Carbon\Carbon::parse($it_ticket->updated_at);
            $diff_in_days = $created_at->diffInDays($updated_at);
            $it_ticket->days_difference = $diff_in_days;
        });

        return $it_tickets;        
    }*/

    public function listado_reporte_ticket(Request $data)
    {            
        if ($data["action"]) {
            $month = $this->convertirMesANumero($data["action"]);
            
            $it_tickets = it_ticket::whereMonth('created_at', $month)
                                    ->orderBy('id', 'DESC')
                                    ->get();
    
            
        } else {
            $it_tickets = it_ticket::orderBy('id', 'DESC')->get();
            
        }
    
        $it_tickets->each(function ($it_ticket) {
            $created_at = \Carbon\Carbon::parse($it_ticket->created_at);
            $updated_at = \Carbon\Carbon::parse($it_ticket->updated_at);
            $diff_in_days = $created_at->diffInDays($updated_at);
            $it_ticket->days_difference = $diff_in_days;
    
            // Concatenar usuario, sede y departamento
            $it_ticket->usuario = $it_ticket->usuario;
        });
    
        return $it_tickets;        
    }
    
    public function convertirMesANumero($mes)
    {
        $meses = [
            'enero' => 1,
            'febrero' => 2,
            'marzo' => 3,
            'abril' => 4,
            'mayo' => 5,
            'junio' => 6,
            'julio' => 7,
            'agosto' => 8,
            'septiembre' => 9,
            'octubre' => 10,
            'noviembre' => 11,
            'diciembre' => 12,
        ];

        return $meses[strtolower($mes)];
    }
        



    public function dictamen(Request $request)
    {
        $datosSolicitud = $request;
        $dictamen = $datosSolicitud['txt_dictamen'];                
        $registro = $datosSolicitud['registro'];                
        $status = "FINALIZADA";
        //$ticket = rand();
        //return $datosSolicitud;        
        $query = it_ticket::where('registro',$datosSolicitud['registro'])->first();                
        $id = $query->id;
        $email = $query->email;
        $descripcion = $query->descripcion;
        $ticket = $query->registro;
                                        
        $Actualizar = it_ticket::findOrFail($id);            
        $Actualizar->status = $status;        
        $Actualizar->descripcion = $descripcion.' Dictámen: '.$dictamen;        
        $Actualizar->save();

        //$record = it_ticket::create($datosSolicitud);
        //$record->save();
        //$last_data = $record->id;
        previoPagoMail::dispatch($email, $ticket, 501);
        echo $ticket;
        
    }


    public function conformidadOk($client_name) {
              
        $query = it_ticket::where('registro',$client_name)->first();                
        $id = $query->id;
        $email = $query->email;
        $descripcion = $query->descripcion;
        $ticket = $query->registro;
        $status = "FINALIZADA_CONFORME";
        
        $Actualizar = it_ticket::findOrFail($id);            
        $Actualizar->status = $status;                
        $Actualizar->save();
        return redirect()->back()->with('success', 'Datos actualizados');        
    }

    public function conformidadFail($client_name) {
        
        $query = it_ticket::where('registro',$client_name)->first();                
        $id = $query->id;
        $email = $query->email;
        $descripcion = $query->descripcion;
        $ticket = $query->registro;
        $status = "NO_CONFORME";
        
        $Actualizar = it_ticket::findOrFail($id);            
        $Actualizar->status = $status;                
        $Actualizar->save();
        return redirect()->back()->with('success', 'Datos actualizados');        
    }

    public function generarBoleta(Request $request){

        
        $ticket = it_ticket::where('registro', $request["registro"])->first();

        $fecha = $ticket->fecha;
        $registro = $ticket->registro;
        $usuario = $ticket->usuario;
        $email = $ticket->email;
        $descripcion = $ticket->descripcion;
        $status = $ticket->status;
        $sede = $ticket->sede;
        $departamento = $ticket->departamento;


         // Cálculo de los días transcurridos
        $created_at = \Carbon\Carbon::parse($ticket->created_at);
        $updated_at = \Carbon\Carbon::parse($ticket->updated_at);
        $diff_in_days = $created_at->diffInDays($updated_at);
        
        $html = '<!DOCTYPE html>
        <html>
        <head>
        <title> ' . $registro . '</title>
        <style type="text/css">
        @page {
            size: A4;
            margin: 30px;
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
       
        </div>
        <br><br>
        <table class="demo">
        <tbody>
        <tr>
        <td><b>Ticket ID:</b></td>
        <td>' . $registro . '</td>
        </tr>
        <tr>
        <td><b>Fecha:</b></td>
        <td>' . $fecha . '</td>
        </tr>
        <tr>
        <td><b>Días transcurridos:</b></td>
        <td>' . $diff_in_days . '</td>
        </tr>
        <tr>
        <td><b>Fecha cierre:</b></td>
        <td>' . $updated_at . '</td>
        </tr>
        <tr>
        <td><b>Sede:</b></td>
        <td>' . $sede . '</td>
        </tr>
        
        <tr>
        <td><b>Departamento:</b></td>
        <td>' . $departamento . '</td>
        </tr>
        <tr>
        <td><b>Usuario:</b></td>
        <td>' . $usuario . '</td>
        </tr>
        <tr>
        <td><b>Email:</b></td>
        <td>' . $email . '</td>
        </tr>
        <tr>
        <td><b>Descripción:</b></td>
        <td>' . $descripcion . '</td>
        </tr>
        <tr>
        <td><b>Status:</b></td>
        <td>' . $status . '</td>
        </tr>
        </tbody>
        </table>
        <br>
        <br>
        <div class=".center">
        
        <p> UUID: ' . $registro . '  </p>
        </div>
        </body>
        </html>';
        
        $pdf = PDF::loadHTML($html);
        $pdf->setPaper("a4", "portrait");
        
        $path = public_path('/pdf');
        $date = date('Y_m_d_H_i_s');
        $fileName = 'Ticket_IT' . '_' . $registro . '_' . $date . '.' . 'pdf';
        
        $pdf->save($path . '/' . $fileName);
        //$emailreceptor = $ticket->email;
        
        // Descargar el archivo PDF
        //return $pdf->download($fileName);
        $url = asset($path . '/' . $fileName);
        return $fileName;
        // Llamada a la función de envío de correo con los datos necesarios.
        // TicketMail::dispatch($emailreceptor, $registro, 200);
        
     
    }
    

    public function txt_mail(Request $request)
    {
        $datosSolicitud = $request;
        $sub = $datosSolicitud['subject'];
        $ticket = rand();
        previoPagoMail::dispatch($sub, $ticket, 500);        
        echo "Successfully sent the email";        
    }
}
