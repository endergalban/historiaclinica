<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Municipio;
use Carbon\Carbon;
use App\Medico;
use App\Asistente;
use App\Arl;
use App\Afp;
use App\Paciente;
USE App\Empresa;


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
        $role_paciente = Role::where(['descripcion'=>'paciente'])->first();
    	$municipio = Municipio::where(['descripcion'=>'Maracaibo'])->first();
        $empresa = Empresa::where(['descripcion'=>"CRUZ BLANCA"])->first();
        $arl = Arl::where(['descripcion'=>"ALR SURA"])->first();
        $afp = Afp::where(['descripcion'=>"FONDO NACIONAL DE AHORRO"])->first();        
        
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
        $user->email = 'alvaromonsalve@yahoo.com.co';
        $user->tipodocumento = 'TI';
        $user->numerodocumento = '11223344';
        $user->primernombre = 'Alvaro';
        $user->segundonombre = '';
        $user->primerapellido = 'Monsalve';
        $user->segundoapellido = '';
        $user->fechanacimiento = Carbon::now();
        $user->genero = 'Masculino';
        $user->estadocivil = 'Soltero';
        $user->municipio()->associate($municipio);
        $user->direccion = 'Bogota';
        $user->ocupacion = 'Ingeniero';
        $user->telefono = '00573126688172';
        $user->firma = '';
        $user->imagen = '';
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

        $user= new User;
        $user->email = 'paciente@hotmail.com';
        $user->tipodocumento = 'TI';
        $user->numerodocumento = '122334566';
        $user->primernombre = 'Jose';
        $user->segundonombre = '';
        $user->primerapellido = 'Paciente';
        $user->segundoapellido = '';
        $user->fechanacimiento = Carbon::now();
        $user->genero = 'Maculino';
        $user->estadocivil = 'Divorciado';
        $user->municipio()->associate($municipio);
        $user->direccion = 'Avenida 12';
        $user->ocupacion = '';
        $user->telefono = '058424000000';
        $user->firma = '';
        $user->imagen = '';
        $user->activo = true;
        $user->password = bcrypt('123456');
        $user->save();
        $user->roles()->attach($role_paciente);

        $paciente = new Paciente;
        $paciente->user()->associate($user);
        $paciente->empresa()->associate($empresa);
        $paciente->arl()->associate($arl);
        $paciente->afp()->associate($afp);
        $paciente->municipio()->associate($municipio);
        $paciente->save();


       /* $user= new User;
        $user->email = 'paciente2@hotmail.com';
        $user->tipodocumento = 'TI';
        $user->numerodocumento = '6655442231';
        $user->primernombre = 'Maria';
        $user->segundonombre = '';
        $user->primerapellido = 'Paciente';
        $user->segundoapellido = '';
        $user->fechanacimiento = Carbon::now();
        $user->genero = 'Femenino';
        $user->estadocivil = 'Soltero';
        $user->municipio()->associate($municipio);
        $user->direccion = 'Avenida 15';
        $user->ocupacion = '';
        $user->telefono = '058424000001';
        $user->firma = '';
        $user->imagen = '';
        $user->activo = true;
        $user->password = bcrypt('123456');
        $user->save();
        $$user->roles()->attach($role_paciente);

        $paciente = new Paciente;
        $paciente->user()->associate($user);
        $paciente->empresa()->associate($empresa);
        $paciente->arl()->associate($arl);
        $paciente->afp()->associate($afp);
        $paciente->municipio()->associate($municipio);
        $paciente->save();
        
        $user= new User;
        $user->email = 'paciente3@hotmail.com';
        $user->tipodocumento = 'CC';
        $user->numerodocumento = '9988244125';
        $user->primernombre = 'Carlos';
        $user->segundonombre = '';
        $user->primerapellido = 'Paciente';
        $user->segundoapellido = '';
        $user->fechanacimiento = Carbon::now();
        $user->genero = 'Masculino';
        $user->estadocivil = 'Soltero';
        $user->municipio()->associate($municipio);
        $user->direccion = 'Avenida 15';
        $user->ocupacion = '';
        $user->telefono = '058424000001';
        $user->firma = '';
        $user->imagen = '';
        $user->activo = true;
        $user->password = bcrypt('123456');
        $user->save();
        $user->roles()->attach( $role_paciente);

        $paciente = new Paciente;
        $paciente->user()->associate($user);
        $paciente->empresa()->associate($empresa);
        $paciente->arl()->associate($arl);
        $paciente->afp()->associate($afp);
        $paciente->municipio()->associate($municipio);
        $paciente->save();*/
       

    }
}
