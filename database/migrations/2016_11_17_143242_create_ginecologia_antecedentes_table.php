<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGinecologiaAntecedentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ginecologia_antecedentes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medico_paciente_id')->unsigned(); $table->foreign('medico_paciente_id')->references('id')->on('medico_pacientes')->onDelete('restrict');
            $table->text('alergias');
            $table->text('ingresos');
            $table->text('traumatismos');
            $table->text('tratamientos');
            $table->boolean('hta');
            $table->boolean('displidemia');
            $table->boolean('dm');
            $table->text('otros');
            $table->text('habitos');
            $table->text('situacion');
            $table->text('familiares');
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
        Schema::dropIfExists('ginecologia_antecedentes');
    }
}
