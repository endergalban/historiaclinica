<?php

use Illuminate\Database\Seeder;
use App\Tiempo_licor;

class TiempoLicoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Tiempo_licor= New Tiempo_licor;
        $Tiempo_licor->descripcion = 'N/A';
        $Tiempo_licor->save();

        $Tiempo_licor = new Tiempo_licor;
        $Tiempo_licor->descripcion ='Semanal';
        $Tiempo_licor->save();

        $Tiempo_licor = new Tiempo_licor;
        $Tiempo_licor->descripcion ='Quincenal';
        $Tiempo_licor->save();

        $Tiempo_licor = new Tiempo_licor;
        $Tiempo_licor->descripcion ='Mensual';
        $Tiempo_licor->save();

        $Tiempo_licor = new Tiempo_licor;
        $Tiempo_licor->descripcion ='Ocacional';
        $Tiempo_licor->save();
    }
}
