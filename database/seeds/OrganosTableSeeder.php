<?php

use Illuminate\Database\Seeder;
use App\Tipo_organo;
use App\Organo;

class OrganosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$Tipo_organo = Tipo_organo::where([ 'descripcion' => 'General' ])->first();
        
        $Organo = new Organo;
        $Organo->descripcion ='Estado Nutricional';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Piel Y faneras';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Cicatrices y Tatuajes	';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Craneo';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Cuello y tiroides';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Tórax';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Senos';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Pulmones';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Corazón';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Tobillos';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Ganglios';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Genitales';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Pulso(Radial, pedio)';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Várices';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Impresión sicologica';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Tipo_organo = Tipo_organo::where([ 'descripcion' => 'Ojos' ])->first();

        $Organo = new Organo;
        $Organo->descripcion ='Fondo de Ojos';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Conjuntivitis';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Párpados';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Córnea';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Reflejos';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Pupilas';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

		$Tipo_organo = Tipo_organo::where([ 'descripcion' => 'Nariz' ])->first();
		
        $Organo = new Organo;
        $Organo->descripcion ='Cometes';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Mucosa nasal';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

		$Tipo_organo = Tipo_organo::where([ 'descripcion' => 'Boca' ])->first();

        $Organo = new Organo;
        $Organo->descripcion ='Paladar';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Dentadura';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Lengua';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Tipo_organo = Tipo_organo::where([ 'descripcion' => 'Faringe' ])->first();

        $Organo = new Organo;
        $Organo->descripcion ='Amígdalas';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Labios';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Mucosa Bucal';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Tipo_organo = Tipo_organo::where([ 'descripcion' => 'Oidos' ])->first();

        $Organo = new Organo;
        $Organo->descripcion ='Pabellón';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='CAE';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Timpanos';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Tabique';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Tipo_organo = Tipo_organo::where([ 'descripcion' => 'Abdomen' ])->first();

        $Organo = new Organo;
        $Organo->descripcion ='Sistema digestivo';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Exploracion Higado';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Exploracion bazo';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Exploracion riñones';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Hernias';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();


        $Tipo_organo = Tipo_organo::where([ 'descripcion' => 'Sistema Nervioso' ])->first();

        $Organo = new Organo;
        $Organo->descripcion ='Reflejos';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Marcha';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='fuerza segmentaria';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Sensibilidad';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

    	$Tipo_organo = Tipo_organo::where([ 'descripcion' => 'Osteo muscular' ])->first();
        
        $Organo = new Organo;
        $Organo->descripcion ='Cuello';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Torax';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Abdomen	';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Miembros Superiores';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Miembros Inferiores';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Codo';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Muñeca';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Cadera';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Rodillas';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Tobillos';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

		$Tipo_organo = Tipo_organo::where([ 'descripcion' => 'Columna vertebral' ])->first();

        $Organo = new Organo;
        $Organo->descripcion ='Inspección > Simetria';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Inspección > Curvatura';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Palpación';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Movilidad > Flexion';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Movilidad > Extencion';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Movilidad > Rotacion';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Marcha > Puntas';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Marcha > Talones';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Reflejos > Patear';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Reflejos > Aquiliano';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Trofismo muscular';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Tipo_organo = Tipo_organo::where([ 'descripcion' => 'Miembro superior (Muñeca)' ])->first();

        $Organo = new Organo;
        $Organo->descripcion ='Inspección';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Palpación';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Flexión';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Flexión palmar';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Desviación radial';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Desviación cubital';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Signo de Phalen';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Reflejos > Estilo radial';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        $Organo = new Organo;
        $Organo->descripcion ='Reflejos > Trofismo';
        $Organo->tipo_organo()->associate($Tipo_organo);
        $Organo->save();

        
    }
}
