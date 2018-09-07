<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oferta', function (Blueprint $table) {
            $table->integer('idTitulacion')->unsigned();
            $table->integer('idCentro')->unsigned();
            $table->primary(array('idTitulacion', 'idCentro'));
            $table->foreign('idTitulacion')->references('idTitulacion')->on('titulacion');
            $table->foreign('idCentro')->references('idCentro')->on('centro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oferta');
    }
}
