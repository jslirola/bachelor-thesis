<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTieneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiene', function (Blueprint $table) {
            $table->integer('idTitulacion')->unsigned();
            $table->integer('idTema')->unsigned();
            $table->primary(array('idTitulacion', 'idTema'));
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
        Schema::dropIfExists('tiene');
    }
}
