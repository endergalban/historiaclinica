<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGinecologiaExploracionInicialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ginecologia_exploracion_iniciales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medico_paciente_id')->unsigned(); $table->foreign('medico_paciente_id','gin_exp_ini_med_pa_01')->references('id')->on('medico_pacientes')->onDelete('restrict');
            $table->string('semanaamenorrea');
            $table->string('sacogestacional');
            $table->string('formasaco');
            $table->boolean('visualizacionembrion');
            $table->integer('numeroembriones');
            $table->boolean('actividadmotora');
            $table->boolean('actividadcardiaca');
            $table->integer('longitud');
            $table->boolean('corionanterior');
            $table->boolean('corionposterior');
            $table->boolean('corioncervix');
            $table->text('ecocardiagrama');
            $table->text('observaciones');
            $table->text('fechaparto');
            $table->boolean('activa');
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
        Schema::dropIfExists('ginecologia_exploracion_iniciales');
    }
}
