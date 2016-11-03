<?php

use Illuminate\Database\Seeder;
use App\Actividad;

class ActividadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actividad= New Actividad;
    	$actividad->descripcion = 'Sentado';
		$actividad->save();
		$actividad= New Actividad;
    	$actividad->descripcion = 'Parado';
		$actividad->save();
		$actividad= New Actividad;
    	$actividad->descripcion = 'Deambulando';
		$actividad->save();
    }
}
