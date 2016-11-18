<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGinecologiaGinecobstetricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ginecologia_ginecobstetricos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medico_paciente_id')->unsigned(); $table->foreign('medico_paciente_id')->references('id')->on('medico_pacientes')->onDelete('restrict');
            $table->boolean('gestante');
            $table->date('fum');
            $table->boolean('seguridad');
            $table->integer('cesarias');
            $table->integer('partos');
            $table->integer('abortos');
            $table->integer('gestaciones');
            $table->date('fpp');
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
        Schema::dropIfExists('ginecologia_ginecobstetricos');
    }
}
