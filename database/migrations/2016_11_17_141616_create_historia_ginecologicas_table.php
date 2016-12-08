<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriaGinecologicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historia_ginecologicas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medico_paciente_id')->unsigned(); $table->foreign('medico_paciente_id')->references('id')->on('medico_pacientes')->onDelete('restrict');
            $table->text('motivo_consulta');
            $table->text('enfermedad_actual');
            $table->text('informe');
            $table->text('analisis');
            $table->text('recomendaciones');
            $table->boolean('activa',1);
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
        Schema::dropIfExists('historia_ginecologicas');
    }
}
