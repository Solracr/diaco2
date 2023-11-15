<?php

namespace App\Http\Controllers;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function listadoEmpresas(Request $received_data)
    {
        return Empresa::where('user_id', auth()->id())->get();        
    }


    public function consultarEmpresa(Request $request)
    {
        $solicitud = $request['idEmpresa'];        
        //$solicitud = 1;
        
        $data = Empresa::where('empresas.id', '=', $solicitud)              		
                    ->orderBy('empresas.id', 'DESC')              		
                    ->get(['empresas.id', 'empresas.nit', 'empresas.razonSocial', 'empresas.domicilio', 'empresas.tipoEntidad', 'empresas.cantidadTrabajadores',                       
                      'empresas.telefono', 'empresas.correo', 'empresas.direccionNotificaciones','empresas.actividadEconomica', 'empresas.departamento', 'empresas.municipio',
                      'empresas.tipo', 'empresas.nitRepresentante', 'empresas.primerNombreRepresentante','empresas.otrosNombresRepresentante', 'empresas.primerApellidoRepresentante', 
                      'empresas.segundoApellidoRepresentante','empresas.cargo', 'empresas.nacionalidad', 'empresas.user_id','empresas.created_at', 'empresas.updated_at']);      
                     
                     
                    //   $data =   array(
                    //     "estado" => 2,
                    //     "mensaje" =>  $solicitud);
        return $data;    
    }

    public function registrarEmpresa(Request $request)
    {
        $datosSolicitud = $request;
        $datosSolicitud['user_id'] = auth()->id();
        $record = Empresa::create($datosSolicitud->all());
        return $record->id;        
    }

    public function actualizarEmpresa(Request $request)
    {
        $datosSolicitud = $request;
        $datosSolicitud['user_id'] = auth()->id();
        //$record = Empresa::create($datosSolicitud->all());
        $ahora = date("Y-m-d H:i:s");   
        //$queryTipoAdjunto = Empresa::where('expediente',$datosSolicitud['expediente'])->first();
        //$idExp = $queryTipoAdjunto->id;

        $Actualizar = Empresa::findOrFail($datosSolicitud['idEmpresa']);            
        
        $Actualizar->domicilio = $datosSolicitud['domicilio'];        
        $Actualizar->tipoEntidad = $datosSolicitud['tipoEntidad'];        
        $Actualizar->cantidadTrabajadores = $datosSolicitud['cantidadTrabajadores'];        
        $Actualizar->telefono = $datosSolicitud['telefono'];        
        $Actualizar->correo = $datosSolicitud['correo'];        
        $Actualizar->direccionNotificaciones = $datosSolicitud['direccionNotificaciones'];        
        $Actualizar->actividadEconomica = $datosSolicitud['actividadEconomica'];        
        $Actualizar->departamento = $datosSolicitud['departamento'];        
        $Actualizar->municipio = $datosSolicitud['municipio'];        
        $Actualizar->tipo = $datosSolicitud['tipo'];        
        $Actualizar->nitRepresentante = $datosSolicitud['nitRepresentante'];        
        $Actualizar->primerApellidoRepresentante = $datosSolicitud['primerApellidoRepresentante'];        
        $Actualizar->segundoApellidoRepresentante = $datosSolicitud['segundoApellidoRepresentante'];        
        $Actualizar->primerNombreRepresentante = $datosSolicitud['primerNombreRepresentante'];                
        $Actualizar->otrosNombresRepresentante = $datosSolicitud['otrosNombresRepresentante'];        
        $Actualizar->cargo = $datosSolicitud['cargo'];        
        $Actualizar->nacionalidad = $datosSolicitud['nacionalidad'];        
        $Actualizar->user_id = $datosSolicitud['user_id'];        
        $Actualizar->updated_at = $ahora;        
        $Actualizar->save();
        
        return $Actualizar->id;        
    }


    public function consultarRepresentante(Request $request){
        $datos = $request;        
        $selector = $datos['selector'];  
        $nitRequest = $datos['dato'];  
        $str = str_replace("-", "", $nitRequest);    
        
        //$nitRequest = $request->nit;                                           
        $service = new SatSearchNit();
        $result = null;
        if ($selector == 'nit'){
            $result  = $service->searchNitRepresentante($str);     
        }
        if($selector == 'cui'){
            $result = $service->searchCui($str);
        }        
        return $result;
    }

    public function webserviceSat(Request $request){
        $datos = $request->except('_token');        
        $nitRequest = $datos['nit'];  
        $str = str_replace("-", "", $nitRequest);                              
        //$nitRequest = $request->nit;                                           
        $service = new SatSearchNit();
        $result  = $service->searchNit($str);     
        return $result;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }
}
 


use PhproTest\SoapClient;

class SatSearchNit
{
    private $urlProd, $satPass, $satUser;

    public function __construct()
    {
        $this->urlProd =  env("SAT_WS_WSDL_DEV");
        $this->satPass = env("PWD_SAT");
        $this->satUser = env("USER_SAT");
    }

    public function searchNit($nit)
    {
        try {
            $urlProd = 'https://farm2.sat.gob.gt/sat/rtu_siaf/contribuyente/serviciosWeb/ConsultaSiaf?WSDL';
            $response = new \SoapClient($urlProd);
            $usuarioSat = 'SIAF_SAG';
            $claveSat = 'SECRETO1';
            /*$urlProd = $this->urlProd;
            $response = new \SoapClient($urlProd);
            $usuarioSat = $this->satUser;
            $claveSat   =  $this->satPass;*/
            $datos = [$usuarioSat, $claveSat, $nit];
            //$soapClient = new \SoapClient($urlProd, array('cache_wsdl' => 0, 'trace' => 1, 'soap_version' => SOAP_1_1));
            $function = 'findContribuyenteByNitGC';
            $parameters = $datos;
            /*try {
                $response=$soapClient->__soapCall($function, $parameters);                                
            } catch (\Exception $e) {              
                $response = $soapClient->{$function}($parameters);
                return $e->getMessage();
            }*/
                                            
            $datosEntidadxNit = $this->convertDataNit($response->__soapCall('findContribuyenteByNitGC', $datos));
            
            
            $respuesta = [
                'code' => 200,
                'contribuyente' => $datosEntidadxNit,
                'nit'=>$nit,
                'uri'=> $urlProd
            ];

            return response()->json($respuesta);
        }catch (\Throwable $e){

            $error = [
                'code' => 300,
                'mensaje' => "Error al consultar - - - - - >>>>: ".$e,
                'nit'=>$nit,
                'uri'=> $urlProd
            ];
            return response()->json($error);
        }
    }


    public function searchNitRepresentante($nit)
    {
        try {
            $urlProd = 'https://farm2.sat.gob.gt/sat/rtu_siaf/contribuyente/serviciosWeb/ConsultaSiaf?WSDL';
            $response = new \SoapClient($urlProd);
            $usuarioSat = 'SIAF_SAG';
            $claveSat = 'SECRETO1';
            $datos = [$usuarioSat, $claveSat, $nit];
            $function = 'findContribuyenteByNitGC';
            $parameters = $datos;
                                            
            $datosEntidadxNit = $this->convertDataNitRepresentante($response->__soapCall('findContribuyenteByNitGC', $datos));
            
            
            $respuesta = [
                'code' => 200,
                'contribuyente' => $datosEntidadxNit,
                'nit'=>$nit,
                'uri'=> $urlProd
            ];

            return response()->json($respuesta);
        }catch (\Throwable $e){

            $error = [
                'code' => 300,
                'mensaje' => "Error al consultar - - - - - >>>>: ".$e,
                'nit'=>$nit,
                'uri'=> $urlProd
            ];
            return response()->json($error);
        }
    }

     
    public function searchCui($cui){

        try {
            $urlProd = 'https://farm2.sat.gob.gt/sat/rtu_siaf/contribuyente/serviciosWeb/ConsultaSiaf?WSDL';
            $response = new \SoapClient($urlProd);
            $usuarioSat = 'SIAF_SAG';
            $claveSat = 'SECRETO1';
            
            $datos = [$usuarioSat, $claveSat, $cui];
            $response->__soapCall('getNit', $datos);

            $datosEntidadxNit = $this->convertDataCui($response->__soapCall('getNit', $datos));

            $respuesta = [
                'code' => 200,
                'contribuyente' => $datosEntidadxNit
            ];

            return response()->json($respuesta);
        }catch (\Throwable $e){
            if($e->getCode() == 0){
                $error = [
                    'code' => 301,
                    'mensaje' => "Error al consultar: ".$e->getCode()
                ];
                return response()->json($error);
            }

        }

    }

// Devuelve la data de la busqueda por CUI
    private function convertDataCui($dataResult){

        $data = $dataResult;
        $error = explode('<CODIGO_ERROR>', $data);
        $error2 = $error[0] == "<CONTRIBUYENTES> " ? 1 : 0;       

        if($error2){
            $response = [
                'primerNombreRepresentante'     => 'NoContribuyente',
                'otrosNombresRepresentante'    => '',
                'primerApellidoRepresentante'   => '',
                'segundoApellidoRepresentante'  => '',
                'APELLIDO_CASADA'   => ''

            ];
        }else{
            $NOMBRES                = explode('<NOM><![CDATA[',$data);
            $pNombreClean           = explode(']]',$NOMBRES[1]);
            $primerNombreCompleto   = explode(',',$pNombreClean[0]);

            $response = [
                'primerNombreRepresentante'     => $primerNombreCompleto[3],
                'otrosNombresRepresentante'    => $primerNombreCompleto[4]  == "" ? 0 :$primerNombreCompleto[4],
                'primerApellidoRepresentante'   => $primerNombreCompleto[0],
                'segundoApellidoRepresentante'  => $primerNombreCompleto[1],
                //'APELLIDO_CASADA'   => $primerNombreCompleto[2] == "" ? 0 :  " DE ".$primerNombreCompleto[2]
                //'APELLIDO_CASADA'   => " DE ".$primerNombreCompleto[2]
                'APELLIDO_CASADA'   => ''
            ];
        }


        return $response ;
    }

    private function convertDataNit($dataResult){
        $data = $dataResult;

        $nit_1              = explode('<NIT>', $data);
        $nit_2              = explode('</NIT>', $nit_1[1]);
        $razonSocial        = explode('<NOM><![CDATA[',$data);
        $razonSocial_1      = explode(']]></NOM>',$razonSocial[1]);
        $razonSocialInd     = explode(',',$razonSocial_1[0]);
        $direcCllAve        = explode('<DOM_FIS><COA><![CDATA[',$data);
        $direcCllAve_1      = explode(']]></COA>', $direcCllAve[1]);
        $direcNumCasa       = explode('<NC>',$data);
        $direcNumCasa_1     = explode('</NC>', $direcNumCasa[1]);
        $direcApto          = explode('<APA><![CDATA[', $data);
        $direcApto_1        = explode(']]></APA>', $direcApto[1]);
        $direcZona          = explode('<ZON>',$data);
        $direcZona_1        = explode('</ZON>',$direcZona[1]);
        $direcColo          = explode('<COL><![CDATA[', $data);
        $direcColo_1        = explode(']]></COL>', $direcColo[1]);
        $email              = explode('<EMA><![CDATA[', $data);
        $email_1            = explode(']]></EMA>', $email[1]);
        $telefono           = explode('<TEL>', $data);
        $telefono_1         = explode('</TEL>', $telefono[1]);
        $actividad          = explode('<AECONOMICA><![CDATA[', $data);
        $actividad_1        = explode(']]></AECONOMICA>', $actividad[1]);

        $numCasaApto = $direcNumCasa_1[0] === ' ' ?  "APTO/CASA ".$direcApto_1[0]: $direcNumCasa_1[0];

        $conteo = sizeof($razonSocialInd);
        $razonSocialPublica = '';
        switch ($conteo){
            case 1:
                $razonSocialPublica = $razonSocial_1[0];
                break;
            case 2:
                $razonSocialPublica = $razonSocialInd[0].','.$razonSocialInd[1] ;
                break;
            case 3:
            case 4:
            case 5:
                $razonSocialPublica = $razonSocialInd[3].' '.$razonSocialInd[4].' '.$razonSocialInd[0].' '.$razonSocialInd[1];
                break;
        }

        $flag = false;    
        if(strpos($data,"<REP TIPO='0'>") !== false){ $flag = true; }        
        if($flag){
            $replegal           = explode("<REP TIPO='0'>", $data);
            $replegal_1         = explode('</REP>', $replegal[1]);
            $nit_rep            = explode('<NIT>', $replegal_1[0]);
            $nit_rep_1          = explode('</NIT>', $nit_rep[1]);
            $nom_rep            = explode('<NOM><![CDATA[', $replegal_1[0]);
            $nom_rep_1          = explode(']]></NOM>', $nom_rep[1]);
            $replegal           = explode(',',$nom_rep_1[0]);            


            $conteo = sizeof($replegal);   
            $nomrep1 =  "";
            $nomrep2 =  "";
            $nomrep3 =  "";
            $nomrep4 =  "";
            switch ($conteo){
                case 1:
                    $nomrep1 = $replegal[0];
                    break;
                case 2:
                    $nomrep1 = $replegal[0]; $nomrep2 = $replegal[1] ;
                    break;
                case 3:
                case 4:
                case 5:
                    $nomrep4 = $replegal[0]; $nomrep3 = $replegal[1] ;
                    $nomrep1 = $replegal[3]; $nomrep2 = $replegal[4] ;               
                    break;
            }
            $response = [
                'nit' => $nit_2[0],
                'razonSocial' => $razonSocialPublica,
                'domicilio' => $direcCllAve_1[0]." ".$numCasaApto." ZONA ". $direcZona_1[0] ." ".$direcColo_1[0],
                'correo' => $email_1[0],
                'telefono' => $telefono_1[0],
                'actividadEconomica' => $actividad_1[0],
                'tipo' => 'empresa'
                //'nitRepresentante' => $nit_rep_1[0],
                /*'primerNombreRepresentante' => $nomrep1, 
                'otrosNombresRepresentante' => $nomrep2, 
                'primerApellidoRepresentante' => $nomrep3, 
                'segundoApellidoRepresentante' => $nomrep4,*/
                //'direccionNotificaciones' => $direcCllAve_1[0]." ".$numCasaApto." ZONA ". $direcZona_1[0] ." ".$direcColo_1[0]
            ];        
            
        }else{            
                        
            $response = [
                'nit' => $nit_2[0],
                'razonSocial' => $razonSocialPublica,
                'domicilio' => $direcCllAve_1[0]." ".$numCasaApto." ZONA ". $direcZona_1[0] ." ".$direcColo_1[0],
                'correo' => $email_1[0],
                'telefono' => $telefono_1[0],
                'actividadEconomica' => $actividad_1[0],                
                'tipo' => 'individual'               
            ];            
        }                              
        return $response ;
    }



    private function convertDataNitRepresentante($dataResult){
        $data = $dataResult;

        $nit_1              = explode('<NIT>', $data);
        $nit_2              = explode('</NIT>', $nit_1[1]);
        $razonSocial        = explode('<NOM><![CDATA[',$data);
        $razonSocial_1      = explode(']]></NOM>',$razonSocial[1]);
        $razonSocialInd     = explode(',',$razonSocial_1[0]);
        $direcCllAve        = explode('<DOM_FIS><COA><![CDATA[',$data);
        $direcCllAve_1      = explode(']]></COA>', $direcCllAve[1]);
        $direcNumCasa       = explode('<NC>',$data);
        $direcNumCasa_1     = explode('</NC>', $direcNumCasa[1]);
        $direcApto          = explode('<APA><![CDATA[', $data);
        $direcApto_1        = explode(']]></APA>', $direcApto[1]);
        $direcZona          = explode('<ZON>',$data);
        $direcZona_1        = explode('</ZON>',$direcZona[1]);
        $direcColo          = explode('<COL><![CDATA[', $data);
        $direcColo_1        = explode(']]></COL>', $direcColo[1]);
        $email              = explode('<EMA><![CDATA[', $data);
        $email_1            = explode(']]></EMA>', $email[1]);
        $telefono           = explode('<TEL>', $data);
        $telefono_1         = explode('</TEL>', $telefono[1]);
        $actividad          = explode('<AECONOMICA><![CDATA[', $data);
        $actividad_1        = explode(']]></AECONOMICA>', $actividad[1]);

        $numCasaApto = $direcNumCasa_1[0] === ' ' ?  "APTO/CASA ".$direcApto_1[0]: $direcNumCasa_1[0];

        $primerNombre = "";
        $segundoNombre = "";
        $tercerNombre = "";
        $cuartoNombre = "";                
        $conteo = sizeof($razonSocialInd);
        $razonSocialPublica = '';
        switch ($conteo){
            case 1:
                $razonSocialPublica = $razonSocial_1[0];
                $primerNombre = $razonSocial_1[0];
                break;
            case 2:
                $razonSocialPublica = $razonSocialInd[0].','.$razonSocialInd[1] ;
                $primerNombre = $razonSocialInd[0]; $segundoNombre = $razonSocialInd[1];
                break;
            case 3:
            case 4:
            case 5:
                $razonSocialPublica = $razonSocialInd[3].' '.$razonSocialInd[4].' '.$razonSocialInd[0].' '.$razonSocialInd[1];                
                $tercerNombre = $razonSocialInd[0]; $cuartoNombre = $razonSocialInd[1]; $primerNombre = $razonSocialInd[3]; $segundoNombre = $razonSocialInd[4];
                break;
        }

        $flag = false;    
        if(strpos($data,"<REP TIPO='0'>") !== false){ $flag = true; }        
        if($flag){
            $replegal           = explode("<REP TIPO='0'>", $data);
            $replegal_1         = explode('</REP>', $replegal[1]);
            $nit_rep            = explode('<NIT>', $replegal_1[0]);
            $nit_rep_1          = explode('</NIT>', $nit_rep[1]);
            $nom_rep            = explode('<NOM><![CDATA[', $replegal_1[0]);
            $nom_rep_1          = explode(']]></NOM>', $nom_rep[1]);
            $replegal           = explode(',',$nom_rep_1[0]);            


            $conteo = sizeof($replegal);   
            $nomrep1 =  "";
            $nomrep2 =  "";
            $nomrep3 =  "";
            $nomrep4 =  "";
            switch ($conteo){
                case 1:
                    $nomrep1 = $replegal[0];
                    break;
                case 2:
                    $nomrep1 = $replegal[0]; $nomrep2 = $replegal[1] ;
                    break;
                case 3:
                case 4:
                case 5:
                    $nomrep4 = $replegal[0]; $nomrep3 = $replegal[1] ;
                    $nomrep1 = $replegal[3]; $nomrep2 = $replegal[4] ;               
                    break;
            }
            $response = [
                'nit' => $nit_2[0],
                'razonSocial' => $razonSocialPublica,
                'domicilio' => $direcCllAve_1[0]." ".$numCasaApto." ZONA ". $direcZona_1[0] ." ".$direcColo_1[0],
                'correo' => $email_1[0],
                'telefono' => $telefono_1[0],
                'actividadEconomica' => $actividad_1[0],
                'primerNombreRepresentante' => $primerNombre, 
                'otrosNombresRepresentante' => $segundoNombre, 
                'primerApellidoRepresentante' => $tercerNombre, 
                'segundoApellidoRepresentante' => $cuartoNombre,                
                'tipo' => 'empresa'
            ];        
            
        }else{            
                        
            $response = [
                'nit' => $nit_2[0],
                'razonSocial' => $razonSocialPublica,
                'domicilio' => $direcCllAve_1[0]." ".$numCasaApto." ZONA ". $direcZona_1[0] ." ".$direcColo_1[0],
                'correo' => $email_1[0],
                'telefono' => $telefono_1[0],
                'actividadEconomica' => $actividad_1[0],                
                'primerNombreRepresentante' => $primerNombre, 
                'otrosNombresRepresentante' => $segundoNombre, 
                'primerApellidoRepresentante' => $tercerNombre, 
                'segundoApellidoRepresentante' => $cuartoNombre,
                'tipo' => 'individual'               
            ];            
        }                              
        return $response ;
    }

}

