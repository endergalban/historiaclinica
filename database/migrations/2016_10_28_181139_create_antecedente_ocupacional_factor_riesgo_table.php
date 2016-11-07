<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntecedenteOcupacionalFactorRiesgoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedente_ocupacional_factor_riesgo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('antecedente_ocupacional_id')->unsigned();
            $table->foreign('antecedente_ocupacional_id','ant_ocu_fac_rie_01')->references('id')->on('antecedente_ocupacionales')->onDelete('restrict');
            $table->integer('factor_riesgo_id')->unsigned();
            $table->foreign('factor_riesgo_id','ant_ocu_fac_rie_02')->references('id')->on('factor_riesgos')->onDelete('restrict');
            $table->string('medidacontrol');
            $table->string('tiempoexposicion');
            $table->string('otro');
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
        Schema::dropIfExists('antecedente_ocupacional_factor_riesgo');
    }
}
