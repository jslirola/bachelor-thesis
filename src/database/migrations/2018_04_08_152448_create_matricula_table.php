<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatriculaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matricula', function (Blueprint $table) {
            $table->char('anyo', 4);
            $table->integer('idTitulacion')->unsigned();
            $table->integer('idAlumno')->unsigned();
            $table->primary(array('anyo', 'idTitulacion', 'idAlumno'));
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
        Schema::dropIfExists('matricula');
    }
}
