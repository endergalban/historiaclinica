<?php

use Illuminate\Database\Seeder;
use App\Ginecologia_exploracion_periodo;

class GinecologiaExploracionPeriodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Ginecologia_exploracion_periodo= New Ginecologia_exploracion_periodo;
        $Ginecologia_exploracion_periodo->descripcion = 'PRIMER TRIMESTRE';
        $Ginecologia_exploracion_periodo->save();

        $Ginecologia_exploracion_periodo= New Ginecologia_exploracion_periodo;
    	$Ginecologia_exploracion_periodo->descripcion = 'SEGUNDO TRIMESTRE';
		$Ginecologia_exploracion_periodo->save();
    }
}
