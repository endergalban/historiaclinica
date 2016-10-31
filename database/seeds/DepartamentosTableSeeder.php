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
        
        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Bogota D.C.';
        $departamento->pais()->associate($pais);
        $departamento->save();
        
<<<<<<< HEAD
        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Antioquia';
        $departamento->pais()->associate($pais);
        $departamento->save();

=======
>>>>>>> 110fe3108272e1a2101201d2d72162102f4997d1
        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Antioca';
        $departamento->pais()->associate($pais);
        $departamento->save();
         
    }
}
