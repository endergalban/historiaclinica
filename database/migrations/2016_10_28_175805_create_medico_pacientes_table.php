<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicoPacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medico_pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medico_id')->unsigned();$table->foreign('medico_id')->references('id')->on('medicos')->onDelete('restrict');
            $table->integer('paciente_id')->unsigned();$table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('restrict');
            $table->integer('especialidad_id')->unsigned();$table->foreign('especialidad_id')->references('id')->on('especialidades')->onDelete('restrict');
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
        Schema::dropIfExists('medico_pacientes');
    }
}
