<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactorRiesgosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factor_riesgos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_factor_riesgo_id')->unsigned();$table->foreign('tipo_factor_riesgo_id')->references('id')->on('tipo_factor_riesgos')->onDelete('restrict');
            $table->string('descripcion');
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
        Schema::dropIfExists('factor_riesgos');
    }
}
