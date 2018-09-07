<?php

use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Initial configuration
        if (DB::table('config')->count() == 0) {
            DB::table('config')->insert([
                "anyo_actual" => date('Y'),
                "conv_actual" => 1,
                "fechaIniDefensa" => date('Y-m-d'),
                "fechaFinDefensa" => date('Y-m-d')
            ]);
        }
    }
}
