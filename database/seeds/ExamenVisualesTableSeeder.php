<?php

use Illuminate\Database\Seeder;
use \App\Ojo;
use \App\Tipo_examen_visual;
use \App\Examen_visual;

class ExamenVisualesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
		$ojos_query = Ojo::orderby('id')->get();
    	$tipo_examen_visuales_query = Tipo_examen_visual::orderby('id')->get();
        foreach ($tipo_examen_visuales_query as $tipo_examen_visual) {
    		 foreach ($ojos_query as $ojo) {
    		 	$Examen_visual= New Examen_visual;
	       		$Examen_visual->ojos()->associate($ojo);
	       		$Examen_visual->tipo_examen_visuales()->associate($tipo_examen_visual);
				$Examen_visual->save(); 
    		 }
        }

    }
}
