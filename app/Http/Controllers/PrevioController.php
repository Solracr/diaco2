<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Previo;
use App\Models\Registro;
use App\Models\Solicitud;

class PrevioController extends Controller
{
    //
    public function verificarPrevio(Request $request)
    {        
        return Previo::where('expediente',$request['expediente'])
        ->where('previo',$request['previo'])
        ->where('estado','PENDIENTE')
        ->orderBy('id', 'ASC')->get();    
    }

    
    public function actualizar(Request $request){
        $rx = '300';

        $datosSolicitud = $request;
        $expediente = $datosSolicitud['expediente'];        
        $periodo =  date("Y");
        $query = Previo::where('expediente',$datosSolicitud['expediente'])->first();                
        $id = $query->id;

        $query = Registro::where('expediente',$datosSolicitud['expediente'])
                           ->where('documento','previo')->first();                
        $id_evento = $query->evento_id;

        //NO SURE
        $status = "PREVIO_PAGO";
        /*if($id_evento == 7) $status = 'PREVIO_PAGO';
        if($id_evento == 8) $status = 'PREVIO_TRAMITE';*/

        $query = Registro::where('expediente',$datosSolicitud['expediente'])->first();   
        

        /*if($id_evento == 7 || $id_evento ==8){
            Registro::create(
                ['expediente' => $expediente, 'documento' => 'previo', 'referencia' => auth()->id(), 'estado' => $status, 'periodo' => $periodo , 'comentario' => 'Notificación Enviada', 'evento_id' => $id_evento]
            );   
        }*/
        

        $Actualizar = Previo::findOrFail($id);            
        $Actualizar->estado = 'ACEPTADO';  
        $Actualizar->nombre = $datosSolicitud['nombre'];        
        $Actualizar->tipoDocumento = $datosSolicitud['tipoDocumento'];        
        $Actualizar->numeroDocumento = $datosSolicitud['numeroDocumento'];        
        $Actualizar->save();
              

        /*$query = Solicitud::where('expediente',$datosSolicitud['expediente'])->first();                
        $ids = $query->id;

        $Actualizar = Solicitud::findOrFail($ids);            
        $Actualizar->status = $status;        
        $Actualizar->save();*/
        
        $rx = '200';      
        return $rx;
    }


}
