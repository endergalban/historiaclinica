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
    	$empresa->descripcion = 'Empresa 2';
		$empresa->save();
    }
}
