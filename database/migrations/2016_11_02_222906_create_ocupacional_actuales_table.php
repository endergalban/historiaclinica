<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcupacionalActualesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocupacional_actuales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('historia_ocupacional_id')->unsigned();$table->foreign('historia_ocupacional_id')->references('id')->on('historia_ocupacionales')->onDelete('restrict');
             $table->integer('turno_id')->unsigned();$table->foreign('turno_id')->references('id')->on('turnos')->onDelete('restrict');
            $table->integer('actividad_id')->unsigned();$table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('restrict');
            $table->string('cargoactual',100);
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
        Schema::dropIfExists('ocupacional_actuales');
    }
}
