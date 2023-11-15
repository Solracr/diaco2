<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nacionalidad;
use SoapClient;

class MigracionController extends Controller
{
    public function index(Request $request)
    {
       //$data = User::where('status','1')->orderBy('id','DESC')->paginate(50);
       //return view('analista.migracion',compact('data'));
       //return Nacionalidad::orderBy('GENTILICIO_NAC', 'ASC')->all();           
       $data = Nacionalidad::orderBy('GENTILICIO_NAC', 'ASC')->get();           
       return view('analista.migracion',compact('data'));
    }


    public function buscar(Request $request)
    {
       //$data = User::where('status','1')->orderBy('id','DESC')->paginate(50);
       //return view('analista.migracion',compact('data'));
        return $request;
        $input = $request->all();        
        //$input['user_name'] = $input['email'];
        $ID = $input['txtpasaporte'];
        $NAC = $input['nacionalidad'];
        //$IP_ADDRESS = $_SERVER[HTTP_CLIENT_IP];
        $USUARIO = "usrExtranjeriagt";
        $CLAVE = "Ext2015DGM";							
        $options = array('location'=>'http://181.114.15.77/wsMinTrabaja/ws.php',
                    'uri' => 'http://181.114.15.77/wsMinTrabaja/');
        $api = new SoapClient(null, $options);
        $result = $api->ConsultaExtranjero($ID, $NAC, $USUARIO, $CLAVE);
        $result = obj2array($result);
        $noticias=$result[0];
        $n=count($noticias);							
        //print $noticias["Pasaporte"] . " ";
        //print $noticias["Nombre1"];
        //IMPRIME LOS DATOS EN PANTALLA
        $html = "";
        $html .= "<table>";
        $EXPEDIENTE = $noticias["lSolicitudes"];
        $CARACTER = ",";
        if($EXPEDIENTE!="")
        {
            
            $pos = strpos($EXPEDIENTE, $CARACTER);
            if($pos>0)
            {
                $EXPEDIENTE = substr($EXPEDIENTE,0,$pos);
            }
            $html .= "<tr>";
            $html .= "<td>".$pasaporte."</td>";
            $html .= "<td>".$noticias["nombre1"]."</td>";
            $html .= "<td>".$noticias["nombre2"]."</td>";
            $html .= "<td>".$noticias["apellido1"]."</td>";
            $html .= "<td>".$noticias["apellido2"]."</td>";
            $html .= "<td>".$EXPEDIENTE."</td>";
            
            $result = $api->ConsultaExpediente($EXPEDIENTE, $USUARIO, $CLAVE);
            $result = obj2array($result);
            $noticias2=$result[0];
         
            $html .= "<td>".$tiposolicitud."</td>";
            $html .= "<td>".$estado."</td>";
            $html .= "<td>".$result["fecha"]."</td>";
        }								
        //AQUI JALA LOS DATOS DEL EXPEDIENTE							
        $html .= "</tr>";								
        //var_dump ($api->ConsultaExpediente($EXPEDIENTE, $USUARIO, $CLAVE));
        $html .= "<tr>";
        $html .= "La DIGEM da como concluido un tramite si el estado de la solicitud es: FIRMA EXTRANJERIA, PAGO BANRURAL O TRAMITE CONCLUIDO";
        $html .= "</tr>";
        $html .= "</table>";
        return view('migracion.buscar',compact('html'));
        return $html;			
    }
    
    
}
