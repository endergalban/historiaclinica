<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriaOcupacionalFactorRiesgoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historia_ocupacional_factor_riesgo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('historia_ocupacional_id')->unsigned();
            $table->foreign('historia_ocupacional_id','his_ocu_fac_rie_foreign')->references('id')->on('historia_ocupacionales')->onDelete('restrict');
            $table->integer('factor_riesgo_id')->unsigned();$table->foreign('factor_riesgo_id')->references('id')->on('factor_riesgos')->onDelete('restrict');
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
        Schema::dropIfExists('historia_ocupacional_factor_riesgo');
    }
}
