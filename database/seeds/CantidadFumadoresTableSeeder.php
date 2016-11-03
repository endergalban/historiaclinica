<?php

use Illuminate\Database\Seeder;
use App\Cantidad_fumador;

class CantidadFumadoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Cantidad_fumador= New Cantidad_fumador;
        $Cantidad_fumador->descripcion = 'N/A';
        $Cantidad_fumador->save();

        $Cantidad_fumador= New Cantidad_fumador;
        $Cantidad_fumador->descripcion = '1 o mas al día';
        $Cantidad_fumador->save();

        $Cantidad_fumador= New Cantidad_fumador;
        $Cantidad_fumador->descripcion = 'Mas de 3 al día';
        $Cantidad_fumador->save();

        $Cantidad_fumador= New Cantidad_fumador;
        $Cantidad_fumador->descripcion = 'Mas de 5 al día';
        $Cantidad_fumador->save();

        $Cantidad_fumador= New Cantidad_fumador;
        $Cantidad_fumador->descripcion = 'Mas de 10 al día';
        $Cantidad_fumador->save();

        $Cantidad_fumador= New Cantidad_fumador;
        $Cantidad_fumador->descripcion = 'Mas de 20 al día';
        $Cantidad_fumador->save();
    }
}
