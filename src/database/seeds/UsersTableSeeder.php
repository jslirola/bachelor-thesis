<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Admin General
        if (DB::table('usuario')->count() == 0) {
            DB::table('usuario')->insert([
                "idUsuario" => 1,
                "rolUsuario" => "G|",
                "nombreUsuario" => "admin",
                "emailUsuario" => "admin@tfx.com",
                "telefonoUsuario" => "900000000",
                "dniUsuario" => "00000000A",
                "hashUsuario" => bcrypt('secretsuperpassword'),
                "remember_token" => str_random(50),
                "fechaRegistro" => date('Y-m-d H:i:s')
            ]);
        }

        // Uncomment to generate 50k users
        //factory(App\Models\Usuario::class, 50000)->create();
    }
}
