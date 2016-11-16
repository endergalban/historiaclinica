<?php

use Illuminate\Database\Seeder;
use App\Especialidad;

class EspecialidadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $especialidad= New Especialidad;
    	$especialidad->descripcion = 'Medicina Ocupacional';
		$especialidad->save();

        $especialidad= New Especialidad;
    	$especialidad->descripcion = 'Pediatría';
		$especialidad->save();

        $especialidad= New Especialidad;
    	$especialidad->descripcion = 'Ginecología';
		$especialidad->save();

    }
}