<?php

namespace App\Http\Controllers;

use App\Models\encuestas;
use Illuminate\Http\Request;
use Mail;

class EncuestaController extends Controller
{
    
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return encuestas::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function encuesta_con(Request $request)
    {
        /*$request->validate([
            'usuario'=>'required',
            'correo'=>'required'
        ]);*/
//return $request;
        try{
            /*$imageName = Str::random().'.'.$request->image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('encuesta/image', $request->image,$imageName);
            encuesta::create($request->post()+['image'=>$imageName]);*/
            //date("m/d/Y h:i:s a", time());
            $ahora =  date('d-m-y h:i:s');
            $record = new encuestas();        
            $record->usuario = $request->usuario;            
            $record->correo = $request->correo;  
            $record->conciliador = $request->conciliador;  
            $record->expediente = $request->expediente;  
            $record->telefono = $request->telefono;  
            $record->respuesta1 = $request->respuesta1;  
            $record->respuesta2 = $request->respuesta2;  
            $record->respuesta3 = $request->respuesta3;  
            $record->respuesta4 = $request->respuesta4;  
            $record->respuesta5 = $request->respuesta5; 
            $record->respuesta6 = $request->respuesta6; 
            $record->observaciones = $request->observaciones; 
            //$record->total = (floatval($request->respuesta1)+floatval($request->respuesta2)+floatval($request->respuesta3)+floatval($request->respuesta4)+floatval($request->respuesta5)+floatval($request->respuesta6)); 
            $record->fecha = $ahora;        
            $record->save();
            //encuesta::create($request);

            
            /*Mail::send([], [], function ($message) {
                $message->to('cromero.juba@gmail.com')
                  ->subject('Notificación de Encuesta')                                    
                  ->setBody('<h1>Hola!</h1><p>Nueva encuesta resuelta</p>', 'text/html'); // for HTML rich messages
              });           */
           
           //descomentar
           /*
            $data = array('name'=>'Diaco');
            Mail::send([],$data,function($message){
                $message->to('cromero.juba@gmail.com','Notificaciones DIACO')->subject('Nueva Encuesta de Calidad');
                $message->from('notificacionesdiaco@gmail.com','Notificaciones DIACO');
            });
            */
        


            return response()->json([
                'message'=>'Encuesta fue guardada exitosamente!!'
            ]);
        }catch(\Exception $e){
            return $e;
            /*\Log::error($e->getMessage());
            return response()->json([
                'message'=>'Error de comunicacion==> 404'
            ],500);*/
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\encuesta  $encuesta
     * @return \Illuminate\Http\Response
     */
    public function show(encuestas $encuesta)
    {
        return response()->json([
            'encuesta'=>$encuesta
        ]);
    }

  
    public function update(Request $request, encuestas $encuesta)
    {
        $request->validate([
            'usuario'=>'required',
            'correo'=>'required'            
        ]);

        try{

            $encuesta->fill($request->post())->update();

            /*if($request->hasFile('image')){                
                if($encuesta->image){
                    $exists = Storage::disk('public')->exists("encuesta/image/{$encuesta->image}");
                    if($exists){
                        Storage::disk('public')->delete("encuesta/image/{$encuesta->image}");
                    }
                }

                $imageName = Str::random().'.'.$request->image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('encuesta/image', $request->image,$imageName);
                $encuesta->image = $imageName;
                $encuesta->save();
            }*/


            return response()->json([
                'message'=>'encuesta Updated Successfully!!'
            ]);

        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while updating a encuesta!!'
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\encuesta  $encuesta
     * @return \Illuminate\Http\Response
     */
    public function destroy(encuestas $encuesta)
    {
        try {

           /* if($encuesta->image){
                $exists = Storage::disk('public')->exists("encuesta/image/{$encuesta->image}");
                if($exists){
                    Storage::disk('public')->delete("encuesta/image/{$encuesta->image}");
                }
            }*/

            $encuesta->delete();

            return response()->json([
                'message'=>'encuesta Deleted Successfully!!'
            ]);
            
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while deleting a encuesta!!'
            ]);
        }
    }

}
