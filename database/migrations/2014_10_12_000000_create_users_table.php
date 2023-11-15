<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        ::connection('mysql')->
//        ::connection('')->
        Schema::create('departamentos', function(Blueprint $table){
            $table->increments('id');                        
            $table->string('nombre');
            $table->timestamps();

        });

        Schema::create('municipios', function(Blueprint $table){
            $table->increments('id');    
            $table->integer('departamento_id');            
            $table->string('nombre');
            $table->timestamps();            
        });

        Schema::create('unidades', function(Blueprint $table){
            $table->id();
            $table->string('nombre');
            $table->string('siglas',20)->nullable();
            $table->string('ubicacion_unidad');
            $table->unsignedBigInteger('departamento_id');
            $table->unsignedBigInteger('municipio_id');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('user_name');
            $table->string('email')->unique();
            $table->integer('sede')->nullable();
            $table->unsignedBigInteger('unidad_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('status')->default(1);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('unidad_id')->references('id')->on('unidades')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('unidades');
        Schema::dropIfExists('municipios');
        Schema::dropIfExists('departamentos');

    }
}
