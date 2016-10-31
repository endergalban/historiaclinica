<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriaOcupacionalDiagnosticoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historia_ocupacional_diagnostico', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('historia_ocupacional_id')->unsigned();
            $table->foreign('historia_ocupacional_id','his_ocu_dia_01')->references('id')->on('historia_ocupacionales')->onDelete('restrict');
            $table->integer('diagnostico_id')->unsigned();
            $table->foreign('diagnostico_id','his_ocu_dia_02')->references('id')->on('diagnosticos')->onDelete('restrict');
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
        Schema::dropIfExists('historia_ocupacional_diagnostico');
    }
}
