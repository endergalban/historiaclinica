<?php

use Illuminate\Database\Seeder;
use App\Lateralidad;

class LateralidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lateralidad= New Lateralidad;
        $lateralidad->descripcion = 'N/A';
        $lateralidad->save();$lateralidad= New Lateralidad;
    	$lateralidad->descripcion = 'Diestro';
		$lateralidad->save(); $lateralidad= New Lateralidad;
    	$lateralidad->descripcion = 'Zurdo';
		$lateralidad->save(); $lateralidad= New Lateralidad;
    	$lateralidad->descripcion = 'Ambidiestro';
		$lateralidad->save();
    }
}
