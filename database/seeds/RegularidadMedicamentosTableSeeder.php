<?php

use Illuminate\Database\Seeder;
use App\Regularidad_medicamento;

class RegularidadMedicamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Regularidad_medicamento= New Regularidad_medicamento;
        $Regularidad_medicamento->descripcion = 'N/A';
        $Regularidad_medicamento->save();

        $Regularidad_medicamento= New Regularidad_medicamento;
        $Regularidad_medicamento->descripcion = '1 o mas dosis al día';
        $Regularidad_medicamento->save();

        $Regularidad_medicamento= New Regularidad_medicamento;
        $Regularidad_medicamento->descripcion = 'Mas de 3 dosis al día';
        $Regularidad_medicamento->save();

      
    }
}
