<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspecialidadMedicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('especialidad_medico', function (Blueprint $table) {
            $table->integer('medico_id')->unsigned();$table->foreign('medico_id')->references('id')->on('medicos')->onDelete('restrict');
            $table->integer('especialidad_id')->unsigned();$table->foreign('especialidad_id')->references('id')->on('especialidades')->onDelete('restrict');
            $table->increments('id');
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
        Schema::dropIfExists('especialidad_medico');
    }
}
