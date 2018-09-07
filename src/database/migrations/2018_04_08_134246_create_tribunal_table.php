<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTribunalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tribunal', function (Blueprint $table) {
            $table->char('anyo', 4);
            $table->integer('convocatoria')->unsigned();
            $table->integer('numero')->unsigned();
            $table->datetime('fechaDefensaTribunal')->nullable();
            $table->string('lugarDefensaTribunal', 100)->nullable();
            $table->primary(array('anyo', 'convocatoria', 'numero'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tribunal');
    }
}
