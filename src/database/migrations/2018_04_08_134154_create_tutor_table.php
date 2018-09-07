<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor', function (Blueprint $table) {
            $table->integer('idUsuario')->unsigned();
            $table->integer('idDepartamento')->unsigned();
            $table->string('despacho', 45)->nullable();
            $table->foreign('idUsuario')->references('idUsuario')->on('usuario');
            $table->foreign('idDepartamento')->references('idDepartamento')->on('departamento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutor');
    }
}
