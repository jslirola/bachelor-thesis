<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoordTitulacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coord_titulacion', function (Blueprint $table) {
            $table->integer('idUsuario')->unsigned();
            $table->date('fechaIni')->nullable();
            $table->date('fechaFin')->nullable();
            $table->foreign('idUsuario')->references('idUsuario')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coord_titulacion');
    }
}
