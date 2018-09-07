<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasificaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clasifica', function (Blueprint $table) {
            $table->integer('idTrabajo')->unsigned();
            $table->integer('idTitulacion')->unsigned();
            $table->integer('idTema')->unsigned();
            $table->primary(array('idTrabajo', 'idTitulacion', 'idTema'));
            $table->foreign('idTrabajo')->references('idTrabajo')->on('trabajo');
            $table->foreign('idTitulacion')->references('idTitulacion')->on('titulacion');
            $table->foreign('idTema')->references('idTema')->on('tema');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clasifica');
    }
}
