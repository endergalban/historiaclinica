<?php

use Illuminate\Database\Seeder;
use App\Tipo_factor_riesgo;
use App\Factor_riesgo;

class FactorRiesgosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo = Tipo_factor_riesgo::where([ 'descripcion' => 'Biomecánicos' ])->first();
    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Puesto de trabajo Inadecuado';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Postura de pie prolongada';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Movimientos repetitivos';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Cargas manuales excesivas';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Otros';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();


		$tipo = Tipo_factor_riesgo::where([ 'descripcion' => 'Psicosociales' ])->first();
    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Monotonia';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Repetitividad';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Ritmos intensivos';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Turnos Rotativos';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Horarios Prolongados';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Otros';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();


		$tipo = Tipo_factor_riesgo::where([ 'descripcion' => 'Físicos' ])->first();
    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Ruido';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Calor-Frio';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Aire Acondicionado inadecuado';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Iluminacion Inadecuada';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

		$factor= New Factor_riesgo;
    	$factor->descripcion = 'Otros';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();


		$tipo = Tipo_factor_riesgo::where([ 'descripcion' => 'Químicos' ])->first();
    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Polvos Organicos-Inorganicos';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Fibras';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Liquidos(nieblas y rocios)';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Gases y Vapores';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Humos metalicos';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();	

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Material Particulado';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

		$factor= New Factor_riesgo;
    	$factor->descripcion = 'Otros';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

		$tipo = Tipo_factor_riesgo::where([ 'descripcion' => 'Biológicos' ])->first();
    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Virus';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Bacterias';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Hongos';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Fluidos-Excrementos';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

		$factor= New Factor_riesgo;
    	$factor->descripcion = 'Otros';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

		$tipo = Tipo_factor_riesgo::where([ 'descripcion' => 'Condiciones de Seguridad' ])->first();
    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Mecánico';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Eléctrico';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Locativo';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Accidente de tránsito';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

		$factor= New Factor_riesgo;
    	$factor->descripcion = 'Públicos';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();
	
		$factor= New Factor_riesgo;
    	$factor->descripcion = 'Trabajo en alturas';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Espacios Confinados';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

		$factor= New Factor_riesgo;
    	$factor->descripcion = 'Otros';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

		$tipo = Tipo_factor_riesgo::where([ 'descripcion' => 'Fenómenos Naturales' ])->first();
    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Fenómenos Naturales';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();

    	$factor= New Factor_riesgo;
    	$factor->descripcion = 'Otros';
        $factor->tipo_factor_riesgo()->associate($tipo);
		$factor->save();
    }
}
