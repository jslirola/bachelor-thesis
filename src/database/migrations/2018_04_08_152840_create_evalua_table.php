<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evalua', function (Blueprint $table) {
            $table->char('anyo', 4);
            $table->integer('convocatoria')->unsigned();
            $table->integer('numero')->unsigned();
            $table->integer('idTitulacion')->unsigned();
            $table->integer('idAlumno')->unsigned();
            $table->decimal('calificacion', 5, 2)->unsigned()->nullable();
            $table->primary(array('anyo', 'convocatoria', 'numero', 'idTitulacion', 'idAlumno'), 'index_evalua');
            //$table->foreign('anyo')->references('anyo')->on('tribunal');
            //$table->foreign('convocatoria')->references('convocatoria')->on('tribunal');
            //$table->foreign('numero')->references('numero')->on('tribunal');
            $table->foreign('idTitulacion')->references('idTitulacion')->on('titulacion');
            $table->foreign('idAlumno')->references('idUsuario')->on('alumno');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evalua');
    }
}
