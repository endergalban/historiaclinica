<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(PaisesTableSeeder::class);
    	$this->call(DepartamentosTableSeeder::class);
    	$this->call(MunicipioTableSeeder::class);
    	$this->call(RolesTableSeeder::class);
    	$this->call(UsersTableSeeder::class);
        $this->call(ModulosTableSeeder::class);
        $this->call(EmpresasTableSeeder::class);
        $this->call(AfpsTableSeeder::class);
        $this->call(ArlsTableSeeder::class);
    }
}
