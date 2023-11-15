<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewfieldsColumnOnItTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('it_tickets', function (Blueprint $table) {
            $table->string('caso')->nullable();  
            $table->string('sede')->nullable();  
            $table->string('departamento')->nullable();  
            $table->string('flag1')->nullable();  
            $table->integer('iflag2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('it_tickets', function (Blueprint $table) {
            //
        });
    }
}
