<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$role = new Role;
        $role->descripcion ='administrador';
        $role->save();

        $role = new Role;
        $role->descripcion ='medico';
        $role->save();

        $role = new Role;
        $role->descripcion ='asistente';
        $role->save();

        $role = new Role;
        $role->descripcion ='paciente';
        $role->save();
    }
}
