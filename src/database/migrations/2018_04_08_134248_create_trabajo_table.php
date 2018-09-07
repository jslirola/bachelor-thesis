<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajo', function (Blueprint $table) {
            $table->increments('idTrabajo');
            $table->string('tituloTrabajo', 150);
            $table->text('detalleTrabajo')->nullable();
            $table->decimal('calificacionTrabajo', 5, 2)->unsigned()->nullable();
            $table->tinyInteger('tipoTrabajo')->default('1');
            $table->tinyInteger('estadoTrabajo')->default('1');
            $table->tinyInteger('propuestaAlumno')->default('0');
            $table->integer('alumnoPreasignado1')->unsigned()->nullable();
            $table->integer('alumnoPreasignado2')->unsigned()->nullable();
            $table->dateTimeTz('fechaRegistro');
            $table->foreign('alumnoPreasignado1')->references('idUsuario')->on('usuario');
            $table->foreign('alumnoPreasignado2')->references('idUsuario')->on('usuario');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajo');
    }
}
