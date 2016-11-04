<?php

use Illuminate\Database\Seeder;
use App\Turno;

class TurnosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $turno= New Turno;
        $turno->descripcion = 'N/A';
        $turno->save();$turno= New Turno;
    	$turno->descripcion = 'Diurno';
		$turno->save();$turno= New Turno;
    	$turno->descripcion = 'Nocturno';
		$turno->save();$turno= New Turno;
    	$turno->descripcion = 'Rotatorio';
		$turno->save();
    }
}
