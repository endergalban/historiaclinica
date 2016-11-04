<?php

use Illuminate\Database\Seeder;
use App\Tipo_examen;

class TipoExamenesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo_examen= New Tipo_examen;
        $tipo_examen->descripcion = 'N/A';
        $tipo_examen->save();$tipo_examen= New Tipo_examen;
    	$tipo_examen->descripcion = 'Ingreso';
		$tipo_examen->save();$tipo_examen= New Tipo_examen;
    	$tipo_examen->descripcion = 'Periódico';
		$tipo_examen->save();$tipo_examen= New Tipo_examen;
    	$tipo_examen->descripcion = 'Egreso';
		$tipo_examen->save();$tipo_examen= New Tipo_examen;
    	$tipo_examen->descripcion = 'Reingreso';
		$tipo_examen->save();$tipo_examen= New Tipo_examen;
    	$tipo_examen->descripcion = 'Altura';
		$tipo_examen->save();$tipo_examen= New Tipo_examen;
    	$tipo_examen->descripcion = 'Manipulador de alimentos';
		$tipo_examen->save();
    }
}
