<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirigeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dirige', function (Blueprint $table) {
            $table->char('anyo', 4);
            $table->integer('idTitulacion')->unsigned();
            $table->integer('idTutor')->unsigned();
            $table->integer('idTrabajo')->unsigned();
            $table->primary(array('anyo', 'idTitulacion', 'idTutor', 'idTrabajo'));
            $table->foreign('idTitulacion')->references('idTitulacion')->on('titulacion');
            $table->foreign('idTutor')->references('idUsuario')->on('tutor');
            $table->foreign('idTrabajo')->references('idTrabajo')->on('trabajo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dirige');
    }
}
