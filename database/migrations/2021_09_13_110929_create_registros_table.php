<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');            
            $table->string('expediente');
            $table->string('uuid')->nullable();
            $table->string('documento')->nullable();
            $table->string('referencia')->nullable();
            $table->string('estado')->nullable();  
            $table->string('archivo')->nullable();            
            $table->text('comentario')->nullable();   
            $table->text('recibo')->nullable();   
            $table->text('dictamen')->nullable();   
            $table->integer('periodo')->nullable();   
            $table->bigInteger('evento_id')->default(1)->unsigned();            
            //$table->foreign('evento_id')->references('id')->on('eventos');

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
        Schema::dropIfExists('registros');
    }
}
