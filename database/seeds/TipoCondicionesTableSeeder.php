<?php

use Illuminate\Database\Seeder;
use App\Tipo_condicion;
use App\Tipo_examen;

class TipoCondicionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$Tipo_examen = Tipo_examen::where(['descripcion'=>'Ingreso'])->first();
    	if(!is_null($Tipo_examen))
    	{
    		$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'APTO SIN PATOLOGIA APARENTE';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'APTO CON PATOLOGIA';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'APTO CON RESTRICCIONES';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'APLAZADO';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'NO APTO';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();
    	}

    	$Tipo_examen = Tipo_examen::where(['descripcion'=>'Periódico'])->first();
    	if(!is_null($Tipo_examen))
    	{
    		$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'PUEDE CONTINUAR LABORANDO';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'REUBICACION LABORAL TEMPORAL';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'REUBICACION LABORAL PERMANENTE';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

    	}

    	$Tipo_examen = Tipo_examen::where(['descripcion'=>'Egreso'])->first();
    	if(!is_null($Tipo_examen))
    	{
    		$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'SIN PATOLOGIA APARENTE';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'CON PATOLOGIA PARA SUGERIR EN EPS';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

    	}

    	$Tipo_examen = Tipo_examen::where(['descripcion'=>'Reingreso'])->first();
    	if(!is_null($Tipo_examen))
    	{
    		$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'APTO';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'NO APTO';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'APTO CON RECOMENDACIONES ';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();
		}
    	


    	$Tipo_examen = Tipo_examen::where(['descripcion'=>'Altura'])->first();
   		if(!is_null($Tipo_examen))
    	{
    		$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'APTO';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'NO APTO';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'APTO CON RECOMENDACIONES ';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'APLAZADO';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'NO APLICA';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			
    	}


    	$Tipo_examen = Tipo_examen::where(['descripcion'=>'Especial'])->first();
    	if(!is_null($Tipo_examen))
    	{
    		$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'REINCORPORACION AL PUESTO DE TRABAJO';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'REUBICACION LABORAL TEMPORAL';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'REUBICACION LABORAL PERMANENTE';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

    	}


    	$Tipo_examen = Tipo_examen::where(['descripcion'=>'Manipulador de alimentos'])->first();
    	if(!is_null($Tipo_examen))
    	{
    		$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'APTO';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'NO APTO';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();

			$Tipo_condicion= New Tipo_condicion;
	    	$Tipo_condicion->descripcion = 'APTO CON RECOMENDACIONES ';
	        $Tipo_condicion->tipo_examen()->associate($Tipo_examen);
			$Tipo_condicion->save();
		}
    }
}
