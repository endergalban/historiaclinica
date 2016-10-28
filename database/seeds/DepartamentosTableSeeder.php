<?php

use Illuminate\Database\Seeder;
use App\Departamento;
use App\Pais;
class DepartamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pais = Pais::where(['descripcion'=>'Venezuela'])->first();
    	$departamento= New Departamento;
    	$departamento->descripcion = 'Zulia';
        $departamento->pais()->associate($pais);
		$departamento->save();

        $pais = Pais::where(['descripcion'=>'Venezuela'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Merida';
        $departamento->pais()->associate($pais);
        $departamento->save();
         
    }
}
