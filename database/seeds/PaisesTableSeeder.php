<?php

use Illuminate\Database\Seeder;
use App\Pais;

class PaisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pais= new Pais;
        $pais->descripcion	=	'Venezuela';
        $pais->save();

        $pais= new Pais;
        $pais->descripcion	=	'Colombia';
        $pais->save();
    }
}
