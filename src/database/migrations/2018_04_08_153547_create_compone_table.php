<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compone', function (Blueprint $table) {
            $table->integer('idTutor')->unsigned();
            $table->integer('idTitulacion')->unsigned();
            $table->char('anyo', 4);
            $table->integer('convocatoria')->unsigned();
            $table->integer('numero')->unsigned();
            $table->integer('rolTribunal')->unsigned();
            $table->primary(array('idTutor', 'idTitulacion', 'anyo', 'convocatoria', 'numero', 'rolTribunal'), 'index_compone');
            $table->foreign('idTutor')->references('idUsuario')->on('tutor');
            $table->foreign('idTitulacion')->references('idTitulacion')->on('titulacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compone');
    }
}
