<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGinecologiaDiagnosticosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ginecologia_diagnosticos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('historia_ginecologica_id')->unsigned(); $table->foreign('historia_ginecologica_id')->references('id')->on('historia_ginecologicas')->onDelete('restrict');
            $table->integer('tipo_diagnostico_id')->unsigned();$table->foreign('tipo_diagnostico_id')->references('id')->on('tipo_diagnosticos')->onDelete('restrict');
            $table->string('concepto',500);
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
        Schema::dropIfExists('ginecologia_diagnosticos');
    }
}
