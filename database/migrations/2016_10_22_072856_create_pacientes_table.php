<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->integer('empresa_id')->unsigned();$table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('restrict');
            $table->integer('arl_id')->unsigned();$table->foreign('arl_id')->references('id')->on('arls')->onDelete('restrict');
            $table->integer('afp_id')->unsigned();$table->foreign('afp_id')->references('id')->on('afps')->onDelete('restrict');
            $table->integer('municipio_id')->unsigned();
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
        Schema::dropIfExists('pacientes');
    }
}
