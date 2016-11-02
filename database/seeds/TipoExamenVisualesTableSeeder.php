<?php

use Illuminate\Database\Seeder;
Use App\Ojo;
Use App\Tipo_examen_visual;

class TipoExamenVisualesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 

    	$izquierdo = Ojo::where(['descripcion'=>'Izquierdo'])->first();
    	$derecho = Ojo::where(['descripcion'=>'Derecho'])->first();
    	$ambos = Ojo::where(['descripcion'=>'Ambos'])->first();

        $tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual lejana';
    	$tipo_examen->ojo()->associate($izquierdo);
		$tipo_examen->save();
		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual lejana';
    	$tipo_examen->ojo()->associate($derecho);
		$tipo_examen->save();
		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual lejana';
    	$tipo_examen->ojo()->associate($ambos);
		$tipo_examen->save();

		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual lejana con corrección';
    	$tipo_examen->ojo()->associate($izquierdo);
		$tipo_examen->save();
		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual lejana con corrección';
    	$tipo_examen->ojo()->associate($derecho);
		$tipo_examen->save();
		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual lejana con corrección';
    	$tipo_examen->ojo()->associate($ambos);
		$tipo_examen->save();


		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual cercana';
    	$tipo_examen->ojo()->associate($izquierdo);
		$tipo_examen->save();
		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual cercana';
    	$tipo_examen->ojo()->associate($derecho);
		$tipo_examen->save();
		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual cercana';
    	$tipo_examen->ojo()->associate($ambos);
		$tipo_examen->save();


		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual cercana con corrección';
    	$tipo_examen->ojo()->associate($izquierdo);
		$tipo_examen->save();
		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual cercana con corrección';
    	$tipo_examen->ojo()->associate($derecho);
		$tipo_examen->save();
		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Agudeza visual cercana con corrección';
    	$tipo_examen->ojo()->associate($ambos);
		$tipo_examen->save();


		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Discriminacion de colores';
    	$tipo_examen->ojo()->associate($izquierdo);
		$tipo_examen->save();
		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Discriminacion de colores';
    	$tipo_examen->ojo()->associate($derecho);
		$tipo_examen->save();
		$tipo_examen= New Tipo_examen_visual;
    	$tipo_examen->descripcion = 'Discriminacion de colores';
    	$tipo_examen->ojo()->associate($ambos);
		$tipo_examen->save();


    }
}
