<?php

namespace App\Http\Controllers;

use App\Models\Requisito;
use App\Models\Registro;
use App\Models\Solicitud;
use App\Models\Adjunto;
use Illuminate\Http\Request;
use App\Jobs\previoPagoMail;
use App\Models\User;
<<<<<<< HEAD
=======
// Moldelos API
use App\Models\Archivo;
use App\Models\Boleta;
// Consumir API
use Illuminate\Support\Facades\Http;
>>>>>>> a6d14650e684b4ee169f5fc59ad3ee668d95ec5f

class RequisitoController extends Controller
{
    public function cargarRequisitosExpediente(Request $request)
    {        
        $datosSolicitud = $request;           
        return Requisito::where('expediente',$datosSolicitud['expediente'])->get();               
    }

    public function cargarReqExpApi(Request $request)
    {
        $response = Http::get('http://localhost:3001/api/doc/listar/archivos?expediente='.$request->expediente);

        return $response;
    }

    public function visualizarDocApi(Request $request)
    {
        $response = Http::get('http://localhost:3001/api/doc/descargar/archivo/'.$request->doc.'/'.$request->expediente.'?tipo='.$request->ext);

        return $response;
    }
      
    public function upload(Request $request)
    {
        $ahora = date("Y-m-d H:i:s");    
        $datosSolicitud = $request;            
        $expediente = Solicitud::where('id',$datosSolicitud['id_solicitud'])->first()->expediente;                
        if($request->file_1 != null){
            $fileName = 'f1-'.time().$expediente.'.'.$request->file_1->getClientOriginalExtension();
            $request->file_1->move(public_path('upload'), $fileName);  
            Requisito::insert(
                [
                    'descripcion' => 'Representación Legal', 
                    'archivo' => $fileName, 
                    'expediente' => $expediente,  
                    'user_id' =>auth()->id() 
                ]
            );            
        }
        if($request->file_2 != null){
            $fileName = 'f2-'.time().$expediente.'.'.$request->file_2->getClientOriginalExtension();
            $request->file_2->move(public_path('upload'), $fileName);                  
            Requisito::insert(
                ['descripcion' => 'Pasaporte Autenticado', 'archivo' => $fileName, 'expediente' => $expediente, 'user_id' =>auth()->id() ]
            );            
        }
        if($request->file_3 != null){
            $fileName = 'f3-'.time().$expediente.'.'.$request->file_3->getClientOriginalExtension();
            $request->file_3->move(public_path('upload'), $fileName);                  

            Requisito::insert(
                ['descripcion' => 'Fotocopia autenticada situación migratoria', 'archivo' => $fileName, 'expediente' => $expediente, 'user_id' =>auth()->id() ]
            );            
        }
        if($request->file_4 != null){
            $fileName = 'f4-'.time().$expediente.'.'.$request->file_4->getClientOriginalExtension();
            $request->file_4->move(public_path('upload'), $fileName);                  
            Requisito::insert(
                ['descripcion' => 'Acta Notarial', 'archivo' => $fileName, 'expediente' => $expediente,  'user_id' =>auth()->id() ]
            );            
        }
        if($request->file_5 != null){
            $fileName = 'f5-'.time().$expediente.'.'.$request->file_5->getClientOriginalExtension();
            $request->file_5->move(public_path('upload'), $fileName);                              
            Requisito::insert(
                ['descripcion' => 'Certificación Contable', 'archivo' => $fileName, 'expediente' => $expediente,  'user_id' =>auth()->id() ]
            );            
        }
        if($request->file_6 != null){
            $fileName = 'f6-'.time().$expediente.'.'.$request->file_6->getClientOriginalExtension();
            $request->file_6->move(public_path('upload'), $fileName);                  
            Requisito::insert(
                ['descripcion' => 'Fotocopia autenticada del nombramiento del extranjero', 'archivo' => $fileName, 'expediente' => $expediente, 'user_id' =>auth()->id() ]
            );            
        }
        if($request->file_7 != null){
            $fileName = 'f7-'.time().$expediente.'.'.$request->file_7->getClientOriginalExtension();
            $request->file_7->move(public_path('upload'), $fileName);                  
            Requisito::insert(
                ['descripcion' => 'Declaración Jurada', 'archivo' => $fileName, 'expediente' => $expediente, 'user_id' =>auth()->id() ]
            );                        
        }
        return '200';
    }


    
    public function uploadFile_contratos(Request $request)
    {
        $rx = '300';
        $ahora = date("Y-m-d H:i:s");    
        $datosSolicitud = $request; 
        //return $datosSolicitud;           
        $expediente = Solicitud::where('id',$datosSolicitud['id_solicitud'])->first()->expediente;                        
        $descripcion_archivo = Adjunto::where('id',$datosSolicitud['tipo'])->first()->descripcion;

        //validar si ya existe un tipo de estos en la tabla de requisitos        
        $ctn_requisito = Requisito::where('tipo','=', $datosSolicitud['tipo'])
        ->where('expediente','=', $expediente)->count();
              
        if($request->file_ != null){
            $fileName = $request->tipo.'-'.time().'-'.$expediente.'.'.$request->file_->getClientOriginalExtension();
            $request->file_->move(public_path('upload'), $fileName);                  
            //$request->file_->storeAs('upload', $fileName, 'public');
            Requisito::create(
                ['tipo'=> $request->tipo,'descripcion' => $descripcion_archivo , 'archivo' => $fileName, 'expediente' => $expediente, 'user_id' =>auth()->id() ]
            );      
            $response = [
                'descripcion' => $descripcion_archivo,
                'filename' => $fileName,
            ];
        }else{
            $response = [
                'descripcion' => '300',
                'filename' => null,
            ];
        }
        
        return response()->json($response);
    }
<<<<<<< HEAD
=======
    
    public function cargarArchivoContrato(Request $request)
    {
        $datosSolicitud = $request; 

        $expediente = Solicitud::where('id',$datosSolicitud['id_solicitud'])->first()->expediente;                        
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
>>>>>>> a6d14650e684b4ee169f5fc59ad3ee668d95ec5f


    
    public function uploadFile(Request $request)
    {
        $rx = '300';
        $ahora = date("Y-m-d H:i:s");    
        $datosSolicitud = $request; 
        //return $datosSolicitud;           
        $expediente = Solicitud::where('id',$datosSolicitud['id_solicitud'])->first()->expediente;                        
        $descripcion_archivo = Adjunto::where('id',$datosSolicitud['tipo'])->first()->descripcion;

        //validar si ya existe un tipo de estos en la tabla de requisitos        
        $ctn_requisito = Requisito::where('tipo','=', $datosSolicitud['tipo'])
        ->where('expediente','=', $expediente)->count();

        /*
        if($ctn_requisito>0){
            $rx = '300';
        }else{
            if($request->file_ != null){
                $fileName = $request->tipo.'-'.time().'-'.$expediente.'.'.$request->file_->getClientOriginalExtension();
                $request->file_->move(public_path('upload'), $fileName);                  
                Requisito::create(
                    ['tipo'=> $request->tipo,'descripcion' => $descripcion_archivo , 'archivo' => $fileName, 'expediente' => $expediente, 'user_id' =>auth()->id() ]
                );      
                $rx = $descripcion_archivo;
            }
        }    
        */
        
        if($request->file_ != null){
            $fileName = $request->tipo.'-'.time().'-'.$expediente.'.'.$request->file_->getClientOriginalExtension();
            //$request->file_->move(public_path('upload'), $fileName);                  
            $request->file_->storeAs('upload', $fileName, 'public');
            Requisito::create(
                ['tipo'=> $request->tipo,'descripcion' => $descripcion_archivo , 'archivo' => $fileName, 'expediente' => $expediente, 'user_id' =>auth()->id() ]
            );      
            $rx = $descripcion_archivo;
        }
        return $rx;
        
    }


    
    public function eliminar(Request $request)
    {
        $datosSolicitud = $request;   
        $rx = '300';
        $ahora = date("Y-m-d H:i:s");                     

        $expediente = Solicitud::where('id',$datosSolicitud['id_solicitud'])->first()->expediente;                        
        $descripcion_archivo = Adjunto::where('id',$datosSolicitud['tipo'])->first()->descripcion;

        $del = Requisito::where('tipo','=', $datosSolicitud['tipo'])
        ->where('expediente','=', $expediente)->first();
        $result=Requisito::where('id','=',$del->id)->delete(); 

        if($request->file_ != null){
            $fileName = $request->tipo.'-'.time().'-'.$expediente.'.'.$request->file_->getClientOriginalExtension();
            $request->file_->move(public_path('upload'), $fileName);                  
            Requisito::create(
                ['tipo'=> $request->tipo,'descripcion' => $descripcion_archivo , 'archivo' => $fileName, 'expediente' => $expediente, 'user_id' =>auth()->id() ]
            );      
            $rx = $descripcion_archivo." [Archivo actualizado] ";
        }    
        return $rx;
    }


    
    public function uploadPago(Request $request)
    {
        $rx = '300';
        $ahora = date("Y-m-d H:i:s");    
        $datosSolicitud = $request;            
        $expediente = $datosSolicitud['expediente'];                        
        $descripcion_archivo = Adjunto::where('selector',$datosSolicitud['tipo'])->first()->descripcion;

        //validar si ya existe un tipo de estos en la tabla de requisitos        
        $ctn_requisito = Requisito::where('tipo','=', $datosSolicitud['tipo'])
        ->where('expediente','=', $expediente)->count();
        
        if($request->file_ != null){
            $fileName = $request->tipo.'-'.time().'-'.$expediente.'.'.$request->file_->getClientOriginalExtension();
            $request->file_->move(public_path('upload'), $fileName);                  
            Requisito::create(
                ['tipo'=> $request->tipo,'descripcion' => $descripcion_archivo , 'archivo' => $fileName, 'expediente' => $expediente, 'user_id' =>auth()->id() ]
            );      
            Registro::create(
                ['expediente' => $expediente, 'documento' => 'Pago', 'referencia' => auth()->id(), 'estado' => 'ANALISIS', 'comentario' => 'Datos de pago cargados al sistema', 'evento_id' => 7]
            );   
           
                         
            $query = Solicitud::where('expediente',$datosSolicitud['expediente'])->first();                
            $id = $query->id;
            $email = $query->correoElectronico;
            $analista = $query->analista_id;

            $query2 = User::where('id',$analista)->first();                
            $email_analista = $query2->email;
                    
            $Actualizar = Solicitud::findOrFail($id);
            $Actualizar->status = 'ANALISIS';        
            $Actualizar->save();
            $rx = '200';
            $pagoefectuado = " Pago de arancel efectuado";

            previoPagoMail::dispatch($email, $expediente.$pagoefectuado, 903);
            previoPagoMail::dispatch($email_analista, $expediente.$pagoefectuado, 903);
    
        return $rx;
    }
    
   }
}


