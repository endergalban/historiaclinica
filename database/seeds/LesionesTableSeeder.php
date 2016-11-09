<?php

use Illuminate\Database\Seeder;
use App\Lesion;

class LesionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lesion= New Lesion;
    	$lesion->descripcion = 'Fractura';
		$lesion->save();$lesion= New Lesion;
    	$lesion->descripcion = 'Herida';
		$lesion->save();$lesion= New Lesion;
    	$lesion->descripcion = 'Amputacion';
		$lesion->save();$lesion= New Lesion;
    	$lesion->descripcion = 'Quemadura';
		$lesion->save();$lesion= New Lesion;
    	$lesion->descripcion = 'Trauma';
		$lesion->save();$lesion= New Lesion;
    	$lesion->descripcion = 'Craneano';
		$lesion->save();$lesion= New Lesion;
    	$lesion->descripcion = 'Otros';
		$lesion->save();
    }
}
