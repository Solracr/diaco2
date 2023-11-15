<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_presentacion')->nullable();
            $table->bigInteger('boleta')->nullable();
            $table->string('correoelectronico')->nullable();
            $table->string('nombre_empresa')->nullable();
            $table->string('nombre_comercial')->nullable();
            $table->string('direccion')->nullable();
            $table->string('departamento')->nullable();
            $table->string('municipio')->nullable();
            $table->string('telefono')->nullable();
            $table->string('fax')->nullable();
            $table->string('responsable')->nullable();
            $table->string('cargo')->nullable();
            $table->string('serie')->nullable();
            $table->string('marca')->nullable();
            $table->string('origen')->nullable();
            $table->string('area')->nullable();
            $table->string('tipobalanza')->nullable();
            $table->string('otrosdatos')->nullable();


            $table->string('resolucion')->nullable();
            $table->integer('periodo')->nullable();  
            $table->string('f63a')->nullable();
            $table->string('status')->nullable();

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
        Schema::dropIfExists('pesas');
    }
}
