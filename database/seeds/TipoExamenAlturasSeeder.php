<?php

use Illuminate\Database\Seeder;
use App\Tipo_examen_altura;

class TipoExamenAlturasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Tipo_examen_altura= New Tipo_examen_altura;
        $Tipo_examen_altura->descripcion = 'PATOLOGIA METABOLICAS';
        $Tipo_examen_altura->save();
        $Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'DIABETES DESCOMPENSADA';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'HIPERTIROIDISMO DESCOMPENSADO';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'HIPOTIROIDISMO DESCOMPENSADO';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
        $Tipo_examen_altura->descripcion = 'ALTERACIONES EN COLESTEROL POR ENCIMA DE 300';
        $Tipo_examen_altura->save();
        $Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'ALTERACIONES EN TRIGLICERIDOS POR ENCIMA DE 300';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'ALTERACIONES CARDIOVASCULARES';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'ARRITMIA CARDIACA DESCOMPENSADA';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
        $Tipo_examen_altura->descripcion = 'INSUFICIENCIA CARDIACA DESCOMPENSADA';
        $Tipo_examen_altura->save();
        $Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'PSICOSIS';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'PSICOSIS MANIACO DEPRESIVA';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'SINDROME DEPRESIVO AGUDO';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
        $Tipo_examen_altura->descripcion = 'SINDROME VERTIGINOSO AGUDO';
        $Tipo_examen_altura->save();
        $Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'VERTIGO DE MENIERE AGUDO';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'HIPOACUSIA NEUROSENSORIAL SEVERA BILATERAL';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'DEFECTO DE REFRACCION SEVERO QUE NO CORRIGE CON LENTES';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
        $Tipo_examen_altura->descripcion = 'ALTERACION EN DISCRIMINACÓN EN VISION DE COLORES';
        $Tipo_examen_altura->save();
        $Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'PRESENCIA DE FOBIAS A ALTURAS';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'EPILEPSIA';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'HAY PRESENCIA DE CUALQUIER TIPO DE NISTAGMUS';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura->save();
        $Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'HAY SIGNO DE ROMBERG POSITIVA';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'HAY PRUEBA DE BABINSKY WEIL POSITIVA';
		$Tipo_examen_altura->save();
		$Tipo_examen_altura= New Tipo_examen_altura;
    	$Tipo_examen_altura->descripcion = 'HAY PRUEBA DE WODAC POSITIVA';
		$Tipo_examen_altura->save();
    }
}
