<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoletasCanceladasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boletas_canceladas', function (Blueprint $table) {
            $table->bigIncrements('id_bol');
            $table->integer('id_adj');
            $table->string('selector')->nullable();
            $table->bigInteger('no_boleta');
            $table->string('expediente')->nullable();
            $table->longText('file');
            $table->string('tipo_archivo');
            $table->date('fecha_pago');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boletas_canceladas');
    }
}
