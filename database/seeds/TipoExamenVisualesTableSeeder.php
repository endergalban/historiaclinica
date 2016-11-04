<?php

use Illuminate\Database\Seeder;
Use App\Ojo;
Use App\Tipo_examen_visual;

class TipoExamenVisualesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 

        $tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual lejana';
		$tipo_examen->save();
		
		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual lejana con corrección';
 		$tipo_examen->save();
		
		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual cercana';
    	$tipo_examen->save();

		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual cercana con corrección';
		$tipo_examen->save();

		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Discriminacion de colores';
		$tipo_examen->save();
    }
}
