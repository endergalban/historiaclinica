<?php

use Illuminate\Database\Seeder;
use App\Empresa;

class EmpresasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empresa= New Empresa;
        $empresa->descripcion = 'N/A';
        $empresa->save();

        $empresa= New Empresa;
    	$empresa->descripcion = 'CAFESALUD';
		$empresa->save();

        $empresa= New Empresa;
        $empresa->descripcion = 'CALISALUD';
        $empresa->save();

        $empresa= New Empresa;
        $empresa->descripcion = 'COLMEDICA';
        $empresa->save();


        $empresa= New Empresa;
        $empresa->descripcion = 'CRUZ BLANCA';
        $empresa->save();
    }
}
