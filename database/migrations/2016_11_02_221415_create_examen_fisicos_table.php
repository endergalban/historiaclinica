<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamenFisicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examen_fisicos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('historia_ocupacional_id')->unsigned();$table->foreign('historia_ocupacional_id')->references('id')->on('historia_ocupacionales')->onDelete('restrict');
            $table->integer('lateralidad_id')->unsigned(); $table->foreign('lateralidad_id')->references('id')->on('lateralidades')->onDelete('restrict');
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
        Schema::dropIfExists('examen_fisicos');
    }
}
