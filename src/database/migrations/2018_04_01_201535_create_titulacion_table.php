<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitulacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titulacion', function (Blueprint $table) {
            $table->increments('idTitulacion');
            $table->string('nombreTitulacion', 100);
            $table->tinyInteger('tipoTitulacion')->default('1')->unsigned();
            $table->unique(array('nombreTitulacion', 'tipoTitulacion'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('titulacion');
    }
}
