<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsistenteMedicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistente_medico', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medico_id')->unsigned();$table->foreign('medico_id')->references('id')->on('medicos')->onDelete('restrict');
            $table->integer('asistente_id')->unsigned();$table->foreign('asistente_id')->references('id')->on('asistentes')->onDelete('restrict');
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
        
        Schema::dropIfExists('asistente_medico');
    }
}
