<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleModuloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_modulo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();$table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict');
            $table->integer('modulo_id')->unsigned();$table->foreign('modulo_id')->references('id')->on('modulos')->onDelete('restrict');
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
        Schema::dropIfExists('role_modulo');
    }
}
