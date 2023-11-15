<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormulario63AsTable extends Migration
{
    public function up()
    {
        Schema::create('formulario_63as', function (Blueprint $table) {
            $table->id();
            $table->string('recibo');
            $table->string('regional');
            $table->date('fecha');
            $table->string('consumidor')->nullable();
            $table->string('lugar')->nullable();
            $table->string('deposito');
            $table->string('codigo_multa')->nullable();
            $table->string('oficina');
            $table->string('rubro');
            $table->integer('cantidad');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('formulario_63as');
    }
}

