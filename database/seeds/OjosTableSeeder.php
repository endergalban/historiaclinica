<?php

use Illuminate\Database\Seeder;
use App\Ojo;

class OjosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ojo= New Ojo;
    	$ojo->descripcion = 'Izquierdo';
		$ojo->save();
		$ojo= New Ojo;
    	$ojo->descripcion = 'Derecho';
		$ojo->save();
		$ojo= New Ojo;
    	$ojo->descripcion = 'Ambos';
		$ojo->save();
    }
}
