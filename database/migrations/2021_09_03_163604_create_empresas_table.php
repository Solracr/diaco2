<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nit');
            $table->string('razonSocial');
            $table->text('domicilio')->nullable();
            $table->string('tipoEntidad');
            $table->integer('cantidadTrabajadores')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->string('direccionNotificaciones')->nullable();;
            $table->string('actividadEconomica');
            $table->integer('departamento')->nullable();
            $table->integer('municipio')->nullable();   
            $table->string('tipo')->nullable();   


            $table->string('nitRepresentante')->nullable();
            $table->string('primerNombreRepresentante');
            $table->string('otrosNombresRepresentante')->nullable();
            $table->string('primerApellidoRepresentante')->nullable();
            $table->string('segundoApellidoRepresentante')->nullable();
            $table->string('cargo');
            $table->string('nacionalidad')->nullable();
            

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('empresas');
    }
}
