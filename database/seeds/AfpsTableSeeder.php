<?php

use Illuminate\Database\Seeder;
use App\Afp;

class AfpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $afp= New Afp;
        $afp->descripcion = 'N/A';
        $afp->save();

    	$afp= New Afp;
    	$afp->descripcion = 'FONDO NACIONAL DE AHORRO';
		$afp->save();

        $afp= New Afp;
        $afp->descripcion = 'COLFONDOS PENSIONES Y CESANTIAS';
        $afp->save();

        $afp= New Afp;
        $afp->descripcion = 'PORVENIR S.A';
        $afp->save();

        $afp= New Afp;
        $afp->descripcion = 'OLD MUTUAL';
        $afp->save();


    }
}
