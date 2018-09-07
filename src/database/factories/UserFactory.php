<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Usuario::class, function (Faker $faker) {
    return [
	    "rolUsuario" => "E|",
	    "nombreUsuario" => str_random(10),
	    "apellidosUsuario" => str_random(20),
	    "emailUsuario" => str_random(30) . "@correo.ugr.es",
	    "telefonoUsuario" => rand(900000001, 999999999),
	    "dniUsuario" => rand(40000000, 99999999) . substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1),
	    "hashUsuario" => bcrypt('secret'),
	    "remember_token" => str_random(50),
	    "fechaRegistro" => date('Y-m-d H:i:s')
    ];
});
