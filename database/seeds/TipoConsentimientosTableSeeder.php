<?php

use Illuminate\Database\Seeder;
use App\Tipo_consentimiento;

class TipoConsentimientosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Tipo_consentimiento= New Tipo_consentimiento;
        $Tipo_consentimiento->descripcion = 'N/A';
        $Tipo_consentimiento->save();

        $Tipo_consentimiento= New Tipo_consentimiento;
        $Tipo_consentimiento->descripcion = 'Examen médico SO';
        $Tipo_consentimiento->save();

        $Tipo_consentimiento= New Tipo_consentimiento;
        $Tipo_consentimiento->descripcion = 'Eval. Osteomuscular';
        $Tipo_consentimiento->save();

        $Tipo_consentimiento= New Tipo_consentimiento;
        $Tipo_consentimiento->descripcion = 'Visiometria';
        $Tipo_consentimiento->save();

		$Tipo_consentimiento= New Tipo_consentimiento;
        $Tipo_consentimiento->descripcion = 'Optometria';
        $Tipo_consentimiento->save();

        $Tipo_consentimiento= New Tipo_consentimiento;
        $Tipo_consentimiento->descripcion = 'Espirometria';
        $Tipo_consentimiento->save();

        $Tipo_consentimiento= New Tipo_consentimiento;
        $Tipo_consentimiento->descripcion = 'Audiometria';
        $Tipo_consentimiento->save();

        $Tipo_consentimiento= New Tipo_consentimiento;
        $Tipo_consentimiento->descripcion = 'Prueba Psicometrica';
        $Tipo_consentimiento->save();

        $Tipo_consentimiento= New Tipo_consentimiento;
        $Tipo_consentimiento->descripcion = 'Electrocardiograma';
        $Tipo_consentimiento->save();

        $Tipo_consentimiento= New Tipo_consentimiento;
        $Tipo_consentimiento->descripcion = 'Analisis de sangre';
        $Tipo_consentimiento->save();

        $Tipo_consentimiento= New Tipo_consentimiento;
        $Tipo_consentimiento->descripcion = 'Prueba Psicotécnica';
        $Tipo_consentimiento->save();

        $Tipo_consentimiento= New Tipo_consentimiento;
        $Tipo_consentimiento->descripcion = 'Exámenes para manuipulación de alimentos';
        $Tipo_consentimiento->save();

        $Tipo_consentimiento= New Tipo_consentimiento;
        $Tipo_consentimiento->descripcion = 'Analisis de orina';
        $Tipo_consentimiento->save();

        $Tipo_consentimiento= New Tipo_consentimiento;
        $Tipo_consentimiento->descripcion = 'Otros';
        $Tipo_consentimiento->save();


    }
}
