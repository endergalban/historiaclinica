<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriaOcupacionalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historia_ocupacionales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medico_paciente_id')->unsigned(); $table->foreign('medico_paciente_id')->references('id')->on('medico_pacientes')->onDelete('restrict');
            $table->integer('escolaridad_id')->unsigned();$table->foreign('escolaridad_id')->references('id')->on('escolaridades')->onDelete('restrict');
            $table->integer('tipo_examen_id')->unsigned();$table->foreign('tipo_examen_id')->references('id')->on('tipo_examenes')->onDelete('restrict');
            $table->integer('turno_id')->unsigned();$table->foreign('turno_id')->references('id')->on('turnos')->onDelete('restrict');
            $table->integer('actividad_id')->unsigned();$table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('restrict');
            $table->integer('lateralidad_id')->unsigned(); $table->foreign('lateralidad_id')->references('id')->on('lateralidades')->onDelete('restrict');
            $table->integer('numerohijos');
            $table->integer('numeropersonascargo');
            $table->string('cargoactual',100);
            $table->float('peso');
            $table->float('talla');
            $table->float('imc');
            $table->string('ta');
            $table->string('fc');
            $table->string('fr');
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
        Schema::dropIfExists('historia_ocupacionales');
    }
}
