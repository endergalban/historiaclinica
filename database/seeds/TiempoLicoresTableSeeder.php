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
        $Tiempo_licor->tipo ='';
        $Tiempo_licor->save();

        $Tiempo_licor = new Tiempo_licor;
        $Tiempo_licor->descripcion ='Semanal';
        $Tiempo_licor->tipo ='Si';
        $Tiempo_licor->save();

        $Tiempo_licor = new Tiempo_licor;
        $Tiempo_licor->descripcion ='Quincenal';
        $Tiempo_licor->tipo ='Si';
        $Tiempo_licor->save();

        $Tiempo_licor = new Tiempo_licor;
        $Tiempo_licor->descripcion ='Mensual';
        $Tiempo_licor->tipo ='Si';
        $Tiempo_licor->save();

        $Tiempo_licor = new Tiempo_licor;
        $Tiempo_licor->descripcion ='Ocacional';
        $Tiempo_licor->tipo ='Si';
        $Tiempo_licor->save();

        $Tiempo_licor = new Tiempo_licor;
        $Tiempo_licor->descripcion ='Menos de 1 año';
        $Tiempo_licor->tipo ='Exbebedor';
        $Tiempo_licor->save();

        $Tiempo_licor = new Tiempo_licor;
        $Tiempo_licor->descripcion ='Mas de 1 año';
        $Tiempo_licor->tipo ='Exbebedor';
        $Tiempo_licor->save();

        $Tiempo_licor = new Tiempo_licor;
        $Tiempo_licor->descripcion ='Mas de 5 años';
        $Tiempo_licor->tipo ='Exbebedor';
        $Tiempo_licor->save();

        $Tiempo_licor = new Tiempo_licor;
        $Tiempo_licor->descripcion ='Mas de 10 años';
        $Tiempo_licor->tipo ='Exbebedor';
        $Tiempo_licor->save();
    }
}
