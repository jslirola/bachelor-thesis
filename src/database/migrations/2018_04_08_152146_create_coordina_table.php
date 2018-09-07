<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoordinaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordina', function (Blueprint $table) {
            $table->char('anyo', 4);
            $table->integer('idTitulacion')->unsigned();
            $table->integer('idCoordTitulacion')->unsigned();
            $table->primary(array('anyo', 'idTitulacion'));
            $table->foreign('idTitulacion')->references('idTitulacion')->on('titulacion');
            $table->foreign('idCoordTitulacion')->references('idUsuario')->on('coord_titulacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coordina');
    }
}
