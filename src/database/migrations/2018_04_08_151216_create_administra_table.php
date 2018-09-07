<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administra', function (Blueprint $table) {
            $table->char('anyo', 4);
            $table->integer('idAdmCentro')->unsigned();
            $table->integer('idCentro')->unsigned();
            $table->primary(array('anyo', 'idAdmCentro'));
            $table->foreign('idAdmCentro')->references('idUsuario')->on('adm_centro');
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
        Schema::dropIfExists('administra');
    }
}
