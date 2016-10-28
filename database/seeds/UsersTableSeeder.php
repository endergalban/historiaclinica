<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Municipio;
use Carbon\Carbon;
use App\Medico;
use App\Asistente;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_administrador = Role::where(['descripcion'=>'administrador'])->first();
    	$role_medico = Role::where(['descripcion'=>'medico'])->first();
    	$role_asistente = Role::where(['descripcion'=>'asistente'])->first();
    	$municipio = Municipio::where(['descripcion'=>'Maracaibo'])->first();
        
        $user= new User;
        $user->email = 'endergalban@gmail.com';
        $user->tipodocumento = 'TI';
        $user->numerodocumento = '15938686';
        $user->primernombre = 'Ender';
        $user->segundonombre = 'Alberto';
        $user->primerapellido = 'Galban';
        $user->segundoapellido = 'Rios';
        $user->fechanacimiento = Carbon::now();
        $user->genero = 'Masculino';
        $user->estadocivil = 'Soltero';
        $user->municipio()->associate($municipio);
        $user->direccion = 'Maracaibo';
        $user->ocupacion = 'Programador';
        $user->telefono = '0584146649856';
        $user->firma = '';
        $user->imagen = 'avatar.png';
        $user->activo = true;
        $user->password = bcrypt('123456');
        $user->save();
        $user->roles()->attach($role_administrador);

        $user= new User;
        $user->email = 'enrique.petzold@gmail.com';
        $user->tipodocumento = 'TI';
        $user->numerodocumento = '150000';
        $user->primernombre = 'Enrique';
        $user->segundonombre = '';
        $user->primerapellido = 'Petzold';
        $user->segundoapellido = 'Rodriguez';
        $user->fechanacimiento = Carbon::now();
        $user->genero = 'Masculino';
        $user->estadocivil = 'Casado';
        $user->municipio()->associate($municipio);
        $user->direccion = 'Maracaibo';
        $user->ocupacion = 'Programador';
        $user->telefono = '0584146649856';
        $user->firma = '';
        $user->imagen = 'avatar.png';
        $user->activo = true;
        $user->password = bcrypt('123456');
        $user->save();
        $user->roles()->attach($role_administrador);

        $user= new User;
        $user->email = 'marllyg27@hotmail.com';
        $user->tipodocumento = 'TI';
        $user->numerodocumento = '16780894';
        $user->primernombre = 'Marlly';
        $user->segundonombre = '';
        $user->primerapellido = 'Gonzalez';
        $user->segundoapellido = '';
        $user->fechanacimiento = Carbon::now();
        $user->genero = 'Femenino';
        $user->estadocivil = 'Casado';
        $user->municipio()->associate($municipio);
        $user->direccion = 'Maracaibo';
        $user->ocupacion = '';
        $user->telefono = '0584246320349';
        $user->firma = '';
        $user->imagen = 'avatar.png';
        $user->activo = true;
        $user->password = bcrypt('123456');
        $user->save();
        $user->roles()->attach($role_asistente);
        $asistente = new Asistente;
        $asistente->user()->associate($user);
        $asistente->save();

        $user= new User;
        $user->email = 'eduardojgr@hotmail.com';
        $user->tipodocumento = 'TI';
        $user->numerodocumento = '15479494';
        $user->primernombre = 'Eduardo';
        $user->segundonombre = '';
        $user->primerapellido = 'Galban';
        $user->segundoapellido = '';
        $user->fechanacimiento = Carbon::now();
        $user->genero = 'Maculino';
        $user->estadocivil = 'Casado';
        $user->municipio()->associate($municipio);
        $user->direccion = 'Maracaibo';
        $user->ocupacion = '';
        $user->telefono = '058424000000';
        $user->firma = '';
        $user->imagen = 'avatar.png';
        $user->activo = true;
        $user->password = bcrypt('123456');
        $user->save();
        $user->roles()->attach($role_medico);

        $medico = new Medico;
        $medico->user()->associate($user);
        $medico->registro = '';
        $medico->banner = '';
        $medico->save();

       
    }
}
