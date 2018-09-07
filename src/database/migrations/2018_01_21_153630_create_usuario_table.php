<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('idUsuario');
            $table->string('rolUsuario', 9);
            $table->string('nombreUsuario', 45);
            $table->string('apellidosUsuario', 100)->nullable();
            $table->string('emailUsuario', 100);
            $table->string('telefonoUsuario', 45)->nullable();
            $table->string('dniUsuario', 45)->unique();
            $table->string('hashUsuario', 60);
            $table->tinyInteger('estadoUsuario')->default('0')->nullable();
            $table->rememberToken();
            $table->dateTimeTz('fechaRegistro');
        });

        DB::statement('ALTER TABLE `usuario` ADD `ipRegistro` VARBINARY(16)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `usuario` DROP COLUMN `ipRegistro`');
        Schema::dropIfExists('users');
    }
}
