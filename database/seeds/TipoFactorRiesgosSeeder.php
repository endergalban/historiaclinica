<?php

use Illuminate\Database\Seeder;
use App\Tipo_factor_riesgo;

class TipoFactorRiesgosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo_factor_riego = new Tipo_factor_riesgo;
        $tipo_factor_riego->descripcion ='Biomecánicos';
        $tipo_factor_riego->save();

        $tipo_factor_riego = new Tipo_factor_riesgo;
        $tipo_factor_riego->descripcion ='Psicosociales';
        $tipo_factor_riego->save();

        $tipo_factor_riego = new Tipo_factor_riesgo;
        $tipo_factor_riego->descripcion ='Físicos';
        $tipo_factor_riego->save();

        $tipo_factor_riego = new Tipo_factor_riesgo;
        $tipo_factor_riego->descripcion ='Químicos';
        $tipo_factor_riego->save();

        $tipo_factor_riego = new Tipo_factor_riesgo;
        $tipo_factor_riego->descripcion ='Biológicos';
        $tipo_factor_riego->save();

        $tipo_factor_riego = new Tipo_factor_riesgo;
        $tipo_factor_riego->descripcion ='Condiciones de Seguridad';
        $tipo_factor_riego->save();

        $tipo_factor_riego = new Tipo_factor_riesgo;
        $tipo_factor_riego->descripcion ='FN';
        $tipo_factor_riego->save();
    }
}
