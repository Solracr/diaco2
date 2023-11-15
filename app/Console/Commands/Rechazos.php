<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Registro;
use App\Models\Solicitud;

class Rechazos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rechazos:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rechazo por previo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /* QUERY PARA VALIDAR DIFERENCIA DE TIEMPO EN 8 DIAS*/ 
        $today = date("Y-m-d");
        //$diff = date_diff(date_create($datosSolicitud['fechaNacimiento']), date_create($today));
        $date = strtotime("+9 day");
        //echo date('M d, Y', $date);
        $result = Solicitud::where('status','=','NOTIFICACION')->get();   
        foreach ($result as $key) {
            $diff = date_diff(date_create($today), date_create($key->updated_at));
            $dias = $diff->format('%d');
            if($dias>=9){   
                $Actualizar = Solicitud::findOrFail($key->id);            
                $Actualizar->status = 'RECHAZO';        
                $Actualizar->save();
                previoPagoMail::dispatch($key->email,$key->nombreCompleto,100);             
                //update 
                //send mail
                //rechazo
            }
        }
                        
    }
}
