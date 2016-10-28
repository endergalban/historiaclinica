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
    	$afp->descripcion = 'AFP';
		$afp->save();
    }
}
