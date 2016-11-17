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

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Antioquia';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Caldas';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Bolivar';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'San Andres y Providencia';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Cordoba';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Sucre';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Atlantico';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Boyaca';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Arauca';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Casanare';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Cauca';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Valle de Cauca';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Choco';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Nariño';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Quindio';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Risalda';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Caqueta';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Amazonas';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Guainia';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Giaviare';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Vaupes';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Putumayo';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Cundinamarca';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Meta';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Vichada';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Magdalena';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Cesar';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'La Guajira';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Santander';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Norte de Santander';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Tolima';
        $departamento->pais()->associate($pais);
        $departamento->save();

        $pais = Pais::where(['descripcion'=>'Colombia'])->first();
        $departamento= New Departamento;
        $departamento->descripcion = 'Huila';
        $departamento->pais()->associate($pais);
        $departamento->save();



        
       
    }
}
