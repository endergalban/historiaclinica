<?php

use Illuminate\Database\Seeder;
use App\Escolaridad;

class EscolaridadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $escolaridad= New Escolaridad;
    	$escolaridad->descripcion = 'Analfabeta';
		$escolaridad->save();$escolaridad= New Escolaridad;
    	$escolaridad->descripcion = 'Primaria';
		$escolaridad->save();$escolaridad= New Escolaridad;
    	$escolaridad->descripcion = 'Secundaria';
		$escolaridad->save();$escolaridad= New Escolaridad;
    	$escolaridad->descripcion = 'Técnico';
		$escolaridad->save();$escolaridad= New Escolaridad;
    	$escolaridad->descripcion = 'Tecnólogo';
		$escolaridad->save();$escolaridad= New Escolaridad;
    	$escolaridad->descripcion = 'Universitaria';
		$escolaridad->save();
    }
}
