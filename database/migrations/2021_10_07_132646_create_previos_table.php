<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreviosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('previo');
            $table->string('expediente');
            $table->string('estado')->nullable();;
            $table->string('nombre')->nullable();;
            $table->string('tipoDocumento')->nullable();;
            $table->string('numeroDocumento')->nullable();;
            $table->string('flag')->nullable();
            $table->string('observaciones')->nullable();        
            $table->dateTime('fechahoraRegistro', $precision = 0)->nullable();            
            $table->dateTime('fechahoraVencimiento', $precision = 0)->nullable();            
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
        Schema::dropIfExists('previos');
    }
}
