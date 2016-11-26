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
            $table->integer('ginecologia_exploracion_periodo_id')->unsigned(); $table->foreign('ginecologia_exploracion_periodo_id','gin_exp_per_gin_exp_per_01')->references('id')->on('ginecologia_exploracion_periodos')->onDelete('restrict');
            $table->integer('ginecologia_exploracion_inicial_id')->unsigned(); $table->foreign('ginecologia_exploracion_inicial_id','gin_exp_ini_gin_exp_per_01')->references('id')->on('ginecologia_exploracion_iniciales')->onDelete('restrict');
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
            $table->string('localizacion');
            $table->string('madurez');
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
