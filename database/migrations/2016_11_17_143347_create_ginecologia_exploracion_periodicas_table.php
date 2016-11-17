<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGinecologiaExploracionPeriodicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ginecologia_exploracion_periodicas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('historia_ginecologica_id')->unsigned(); $table->foreign('historia_ginecologica_id')->references('id')->on('historia_ginecologicas')->onDelete('restrict');
            $table->integer('ginecologia_exploracion_periodo_id')->unsigned(); $table->foreign('ginecologia_exploracion_periodo_id')->references('id')->on('ginecologia_exploracion_periodos')->onDelete('restrict');
            $table->string('semanaamenorrea');
            $table->text('situacionfetal');
            $table->text('dorso');
            $table->float('dbp');
            $table->float('lf');
            $table->float('pabdominal');
            $table->boolean('actividadmotora');
            $table->boolean('actividadcardiaca');
            $table->boolean('actividadrespiratoria');
            $table->integer('semanaecografia');
            $table->boolean('corionanterior');
            $table->string('localizacion');
            $table->boolean('madurez');
            $table->text('liquidovolumen');
            $table->text('liquidoobservaciones');
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
        Schema::dropIfExists('ginecologia_exploracion_periodicas');
    }
}
