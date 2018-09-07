<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asigna', function (Blueprint $table) {
            $table->char('anyo', 4);
            $table->integer('idTrabajo')->unsigned();
            $table->integer('numero')->unsigned();
            $table->integer('idAlumno')->unsigned();
            $table->integer('idTitulacion')->unsigned();
            $table->integer('defensa')->unsigned()->nullable();
            $table->integer('convocatoria')->unsigned()->default('0')->nullable();
            $table->primary(array('anyo', 'idTrabajo'));
            $table->foreign('anyo')->references('anyo')->on('matricula');
            $table->foreign('idTitulacion')->references('idTitulacion')->on('titulacion');
            $table->foreign('idAlumno')->references('idUsuario')->on('usuario');
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
        Schema::dropIfExists('asigna');
    }
}
