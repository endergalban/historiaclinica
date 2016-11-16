<?php

use Illuminate\Database\Seeder;
use App\Municipio;
use App\Departamento;
class MunicipioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departamento = Departamento::where([ 'descripcion' => 'Zulia' ])->first();
    	$municipio= New Municipio;
    	$municipio->descripcion = 'Maracaibo';
        $municipio->departamento()->associate($departamento);
		$municipio->save();
		
    	$municipio= New Municipio;
    	$municipio->descripcion = 'Cabimas';
        $municipio->departamento()->associate($departamento);
		$municipio->save();
        
        $municipio= New Municipio;
        $municipio->descripcion = 'Ciudad Ojeda';
        $municipio->departamento()->associate($departamento);
        $municipio->save();$departamento = Departamento::where([ 'descripcion' => 'Zulia' ])->first();
        
        $municipio= New Municipio;
        $municipio->descripcion = 'Lagunillas';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Merida' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Merida';
        $municipio->departamento()->associate($departamento);
        $municipio->save();
/* MUNICIPIOS DE COLOMBIA */
        $departamento = Departamento::where([ 'descripcion' => 'Bogota D.C.' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Bogota D.C.';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Cundinamarca' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Almeidas';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Cundinamarca' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Alto Magdalena';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Cundinamarca' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Bajo Magdalena';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Cundinamarca' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Gualivá';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Cundinamarca' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Guavio';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Cundinamarca' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Magdalena Centro';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Cundinamarca' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Medina';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Cundinamarca' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Oriente';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Cundinamarca' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Rionegro';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Cundinamarca' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Sabana Centro';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Cundinamarca' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Sabana Occidente';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Cundinamarca' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Soacha';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Cundinamarca' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Sumapaz';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Cundinamarca' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Tequendama';
        $municipio->departamento()->associate($departamento);
        $municipio->save();

        $departamento = Departamento::where([ 'descripcion' => 'Cundinamarca' ])->first();
        $municipio= New Municipio;
        $municipio->descripcion = 'Ubaté';
        $municipio->departamento()->associate($departamento);
        $municipio->save();
    }
}
