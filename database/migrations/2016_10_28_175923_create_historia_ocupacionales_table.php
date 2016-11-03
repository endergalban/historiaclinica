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
            $table->integer('empresa_id')->unsigned();$table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('restrict');
            $table->integer('arl_id')->unsigned();$table->foreign('arl_id')->references('id')->on('arls')->onDelete('restrict');
            $table->integer('afp_id')->unsigned();$table->foreign('afp_id')->references('id')->on('afps')->onDelete('restrict');
            $table->integer('escolaridad_id')->unsigned();$table->foreign('escolaridad_id')->references('id')->on('escolaridades')->onDelete('restrict');
            $table->integer('tipo_examen_id')->unsigned();$table->foreign('tipo_examen_id')->references('id')->on('tipo_examenes')->onDelete('restrict');
            $table->integer('numerohijos');
            $table->integer('numeropersonascargo');
            $table->string('empresa');
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
