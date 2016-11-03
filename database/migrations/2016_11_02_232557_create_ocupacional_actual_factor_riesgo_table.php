<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcupacionalActualFactorRiesgoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('ocupacional_actual_factor_riesgo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ocupacional_actual_id')->unsigned();
            $table->foreign('ocupacional_actual_id','ocu_act_fac_rie_01')->references('id')->on('ocupacional_actuales')->onDelete('restrict');
            $table->integer('factor_riesgo_id')->unsigned();
            $table->foreign('factor_riesgo_id','ocu_act_fac_rie_02')->references('id')->on('factor_riesgos')->onDelete('restrict');
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
        //
    }
}
