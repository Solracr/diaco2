<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_tickets', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha', $precision = 0);            
            $table->string('registro')->nullable();            
            $table->integer('idx')->nullable();            
            $table->string('usuario')->nullable();      
            $table->string('email')->nullable();                  
            $table->text('descripcion')->nullable();       
            $table->text('status')->nullable();                         
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
        Schema::dropIfExists('it_tickets');
    }
}
