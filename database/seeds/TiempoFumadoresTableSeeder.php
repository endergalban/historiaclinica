<?php

use Illuminate\Database\Seeder;
use App\Tiempo_fumador;

class TiempoFumadoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Tiempo_fumador= New Tiempo_fumador;
        $Tiempo_fumador->descripcion = 'N/A';
        $Tiempo_fumador->save();

        $Tiempo_fumador = new Tiempo_fumador;
        $Tiempo_fumador->descripcion ='Menos de 1 Año';
        $Tiempo_fumador->save();

        $Tiempo_fumador = new Tiempo_fumador;
        $Tiempo_fumador->descripcion ='Mas de 1 Año';
        $Tiempo_fumador->save();

        $Tiempo_fumador = new Tiempo_fumador;
        $Tiempo_fumador->descripcion ='Mas de 5 Años';
        $Tiempo_fumador->save();

        $Tiempo_fumador = new Tiempo_fumador;
        $Tiempo_fumador->descripcion ='Mas de 10 Años';
        $Tiempo_fumador->save();
    }
}
