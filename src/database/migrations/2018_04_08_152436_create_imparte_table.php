<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImparteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imparte', function (Blueprint $table) {
            $table->char('anyo', 4);
            $table->integer('idTitulacion')->unsigned();
            $table->integer('idTutor')->unsigned();
            $table->primary(array('anyo', 'idTitulacion', 'idTutor'));
            $table->foreign('idTitulacion')->references('idTitulacion')->on('titulacion');
            $table->foreign('idTutor')->references('idUsuario')->on('tutor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imparte');
    }
}
