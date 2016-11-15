<?php

use Illuminate\Database\Seeder;
use App\Tipo_organo;

class TipoOrganosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Tipo_organo = new Tipo_organo;
        $Tipo_organo->descripcion ='General';
        $Tipo_organo->save();

        $Tipo_organo = new Tipo_organo;
        $Tipo_organo->descripcion ='Ojos';
        $Tipo_organo->save();

        $Tipo_organo = new Tipo_organo;
        $Tipo_organo->descripcion ='Nariz';
        $Tipo_organo->save();

        $Tipo_organo = new Tipo_organo;
        $Tipo_organo->descripcion ='Boca';
        $Tipo_organo->save();

        $Tipo_organo = new Tipo_organo;
        $Tipo_organo->descripcion ='Faringe';
        $Tipo_organo->save();

        $Tipo_organo = new Tipo_organo;
        $Tipo_organo->descripcion ='Oidos';
        $Tipo_organo->save();

        $Tipo_organo = new Tipo_organo;
        $Tipo_organo->descripcion ='Abdomen';
        $Tipo_organo->save();

        $Tipo_organo = new Tipo_organo;
        $Tipo_organo->descripcion ='Sistema Nervioso';
        $Tipo_organo->save();

        $Tipo_organo = new Tipo_organo;
        $Tipo_organo->descripcion ='Osteo muscular';
        $Tipo_organo->save();

        $Tipo_organo = new Tipo_organo;
        $Tipo_organo->descripcion ='Columna vertebral';
        $Tipo_organo->save();

        $Tipo_organo = new Tipo_organo;
        $Tipo_organo->descripcion ='Miembro superior (Muñeca)';
        $Tipo_organo->save();

    }
}
