<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Libro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libro', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('fecha_presentacion')->nullable();
            $table->string('nit')->nullable();
            $table->string('razonsocial')->nullable();
            $table->string('direccion')->nullable();
            $table->string('apartamento')->nullable();
            $table->string('zona')->nullable();
            $table->string('coloniabarrio')->nullable();
            $table->string('municipalidad')->nullable();

            $table->integer('departamento')->nullable();  
            $table->integer('municipio')->nullable(); 
            
            $table->string('telefono')->nullable();            
            $table->string('fax')->nullable();            
            $table->string('correoelectronico')->nullable();
            
            
            $table->string('nombreestablecimiento')->nullable();
            $table->string('direccion2')->nullable();
            $table->string('numero_casa')->nullable();
            $table->string('zona_2')->nullable();
            $table->string('coloniabarrio2')->nullable();
            $table->integer('municipio2')->nullable(); 
            $table->integer('departamento2')->nullable();  
            $table->integer('periodo')->nullable();  

//sede regional del departamento 
            $table->integer('sededepartamental')->nullable();            
            $table->string('tipoestablecimiento')->nullable();            

            $table->text('detalle')->nullable();
            $table->string('f63a')->nullable();
            $table->string('representantelegal')->nullable();

            // Incluídas algunas columnas del ejemplo dado:
            $table->bigInteger('user_id')->unsigned();            
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('analista_id')->nullable();

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
        //
    }
}
