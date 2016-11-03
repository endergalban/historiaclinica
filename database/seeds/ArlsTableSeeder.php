<?php

use Illuminate\Database\Seeder;
use App\Arl;

class ArlsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arl= New Arl;
        $arl->descripcion = 'N/A';
        $arl->save();

        $arl= New Arl;
    	$arl->descripcion = 'ARL';
		$arl->save();
    }
}
