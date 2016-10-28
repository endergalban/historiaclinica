<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->string('tipodocumento', 3);
            $table->string('numerodocumento', 15);
            $table->string('primernombre', 50);
            $table->string('segundonombre', 50);
            $table->string('primerapellido', 50);
            $table->string('segundoapellido', 50);
            $table->date('fechanacimiento');
            $table->string('genero', 10);
            $table->string('estadocivil', 50);
            $table->integer('municipio_id')->unsigned();
            $table->string('direccion', 255);
            $table->string('ocupacion', 100);
            $table->string('telefono', 15);
            $table->boolean('activo')->default(true);
            $table->string('firma', 100)->default('');
            $table->string('imagen', 100)->default('avatar.png');
            $table->rememberToken();
            $table->foreign('municipio_id')->references('id')->on('municipios')->onDelete('restrict');
            $table->softDeletes();
            $table->timestamps();
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
