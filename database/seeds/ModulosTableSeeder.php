<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Modulo;

class ModulosTableSeeder extends Seeder
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

        $modulo= new Modulo;
        $modulo->orden = 0;
        $modulo->icono = 'fa-home';
        $modulo->descripcion = 'Escritorio';
        $modulo->site = 'home';
        $modulo->save();
        $modulo->roles()->attach($role_administrador);
        $modulo->roles()->attach($role_medico);
        $modulo->roles()->attach($role_asistente);
        $modulo->roles()->attach($role_paciente);
    	

        $modulo= new Modulo;
        $modulo->orden = 1;
        $modulo->icono = 'fa-users';
        $modulo->descripcion = 'Usuarios';
        $modulo->site = 'users';
        $modulo->save();
        $modulo->roles()->attach($role_administrador);

        $modulo= new Modulo;
        $modulo->orden = 2;
        $modulo->icono = 'fa-list';
        $modulo->descripcion = 'Módulos';
        $modulo->site = 'modulos';
        $modulo->save();
        $modulo->roles()->attach($role_administrador);

        $modulo= new Modulo;
        $modulo->orden = 3;
        $modulo->icono = 'fa-user-md';
        $modulo->descripcion = 'Médicos';
        $modulo->site = 'medicos';
        $modulo->save();
        $modulo->roles()->attach($role_administrador);
        

        $modulo= new Modulo;
        $modulo->orden = 4;
        $modulo->icono = 'fa-user';
        $modulo->descripcion = 'Asistentes';
        $modulo->site = 'asistentes';
        $modulo->save();
        $modulo->roles()->attach($role_administrador);

      
        $modulo= new Modulo;
        $modulo->orden = 5;
        $modulo->icono = 'fa-wheelchair';
        $modulo->descripcion = 'Pacientes';
        $modulo->site = 'pacientes';
        $modulo->save();
        $modulo->roles()->attach($role_administrador);
        $modulo->roles()->attach($role_medico);
        $modulo->roles()->attach($role_asistente);

        $modulo= new Modulo;
        $modulo->orden = 6;
        $modulo->icono = 'fa-newspaper-o';
        $modulo->descripcion = 'Historias';
        $modulo->site = 'historias';
        $modulo->save();
        $modulo->roles()->attach($role_administrador);
        $modulo->roles()->attach($role_medico);
        $modulo->roles()->attach($role_asistente);


       

        $modulo= new Modulo;
        $modulo->orden = 10;
        $modulo->icono = 'fa-medkit';
        $modulo->descripcion = 'Especialidades';
        $modulo->site = 'especialidades';
        $modulo->save();
        $modulo->roles()->attach($role_administrador);

        $modulo= new Modulo;
        $modulo->orden = 11;
        $modulo->icono = 'fa-plus-square';
        $modulo->descripcion = 'EPS';
        $modulo->site = 'empresas';
        $modulo->save();
        $modulo->roles()->attach($role_administrador);
      

        $modulo= new Modulo;
        $modulo->orden = 12;
        $modulo->icono = 'fa-plus-square';
        $modulo->descripcion = 'AFP';
        $modulo->site = 'afps';
        $modulo->save();
        $modulo->roles()->attach($role_administrador);
   

        $modulo= new Modulo;
        $modulo->orden = 13;
        $modulo->icono = 'fa-plus-square';
        $modulo->descripcion = 'ARL';
        $modulo->site = 'arls';
        $modulo->save();
        $modulo->roles()->attach($role_administrador);


        $modulo= new Modulo;
        $modulo->orden = 20;
        $modulo->icono = 'fa-book';
        $modulo->descripcion = 'Citas';
        $modulo->site = 'citas';
        $modulo->save();
        $modulo->roles()->attach($role_asistente);
    
        

       
        
        
    }
}
