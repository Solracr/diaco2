<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicituds', function (Blueprint $table) {                        
            $table->bigIncrements('id');
            $table->string('primerNombre');
            $table->string('otrosNombres')->nullable();            
            $table->string('primerApellido')->nullable();            
            $table->string('otrosApellidos')->nullable();            
            $table->string('apellidoCasada')->nullable();            
            $table->string('nombreCompleto')->nullable();            
            $table->integer('numeroTelefono')->nullable();
            $table->dateTime('fechaNacimiento', $precision = 0)->nullable();
            $table->dateTime('fechaCancelacion', $precision = 0)->nullable();
            $table->dateTime('fechaSolicitudCancelacion', $precision = 0)->nullable();
            

            $table->string('tipo_establecimiento')->nullable();            
            $table->string('nombre_establecimiento')->nullable();            
            $table->string('tipo_solicitud')->nullable();            
            

            $table->string('nacionalidad')->nullable();
            $table->string('genero')->nullable();
            $table->string('estadoCivil')->nullable();
            $table->string('documentoIdentificacion')->nullable();            
            $table->string('numeroDocumento')->nullable();
            $table->string('direccion')->nullable();
            $table->integer('departamento')->nullable();
            $table->integer('municipio')->nullable();           
            $table->string('correoElectronico')->nullable();
            $table->text('profesion')->nullable();            
            //$table->text('profesion')->default('');
                        
            //$table->foreign('ocupacion')->references('id')->on('ocupacions');  
            //$table->foreign('carrera')->references('id')->on('carreras');                          
            //$table->foreign('nivelEstudio')->references('id')->on('nivelacademicos');  


            $table->text('especificarCarrera')->nullable();                        
            $table->string('experiencia')->nullable();                             
            /*$table->bigInteger('ocupacion')->unsigned();                        
            $table->bigInteger('nivelEstudio')->unsigned();                        
            $table->bigInteger('carrera')->unsigned();*/
            $table->bigInteger('ocupacion')->nullable();                        
            $table->bigInteger('nivelEstudio')->nullable();                        
            $table->bigInteger('carrera')->nullable();

            $table->text('idiomas')->nullable();  
            $table->text('motivo')->nullable();    
            $table->text('motivoCancelacion')->nullable(); 
               
                    
            $table->text('observaciones')->nullable(); 
            $table->integer('tipoEntidad')->nullable();           

            $table->string('nombrePlaza')->nullable();
            $table->text('perfilPlaza')->nullable();
            $table->string('funcionesGenerales')->nullable();
            $table->string('periodicidadPago')->nullable();        
            $table->unsignedDecimal('montoPago', $precision = 8, $scale = 2)->nullable();
            


            $table->string('situacionMigratoria')->nullable();
            $table->string('expedienteMigracion')->nullable();
            $table->string('llaveMigracion')->nullable();
                        
            $table->string('razonSocial')->nullable();                                                                     
            $table->string('tipo1');
            $table->string('tipo2');            
            $table->string('periodo');            
            $table->string('expediente')->nullable();
            $table->string('qr')->nullable();
            $table->string('exp1')->nullable();
            $table->string('status')->nullable();            
            $table->integer('codigoEmpresa')->nullable();

            //CASOS ESPECIALES
            $table->string('tipoParentesco')->nullable();
            $table->string('partida')->nullable();
            $table->string('folio')->nullable();
            $table->string('libro')->nullable();
            $table->string('certificadoCui')->nullable();
            
            //REFUGIADOS
            $table->dateTime('fechaIngreso', $precision = 0)->nullable();
            $table->string('trabajoActual')->nullable();
            $table->text('ultimasOcupaciones')->nullable();
            $table->text('parientes')->nullable();

            $table->bigInteger('user_id')->unsigned();            
            $table->foreign('user_id')->references('id')->on('users');            

            $table->bigInteger('analista_id')->nullable();            
            //ANALISTA
            /*$table->bigInteger('analista_id')->unsigned();            
            $table->foreign('analista_id')->references('id')->on('users'); */

            $table->timestamps();           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicituds');
    }
}
