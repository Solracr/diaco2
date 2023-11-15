<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Encuesta extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuestas', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->dateTime('fecha', $precision = 0);            
            $table->string('expediente')->nullable();            
            $table->string('usuario')->nullable();      
            $table->string('telefono')->nullable();      
            $table->string('conciliador')->nullable();      
            $table->string('correo')->nullable();      
            $table->string('respuesta1')->nullable();      
            $table->string('respuesta2')->nullable();      
            $table->string('respuesta3')->nullable();      
            $table->string('respuesta4')->nullable();      
            $table->string('respuesta5')->nullable();      
            $table->string('respuesta6')->nullable();                  
            $table->text('observaciones')->nullable();             
            $table->decimal('total', 5, 4)->nullable();            
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
        Schema::dropIfExists('encuestas');
    }
}
