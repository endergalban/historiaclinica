<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHabitoFumadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habito_fumadores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('historia_ocupacional_id')->unsigned();$table->foreign('historia_ocupacional_id')->references('id')->on('historia_ocupacionales')->onDelete('restrict');
            $table->integer('tiempo_fumador_id')->unsigned(); $table->foreign('tiempo_fumador_id')->references('id')->on('tiempo_fumadores')->onDelete('restrict');
            $table->integer('cantidad_fumador_id')->unsigned();$table->foreign('cantidad_fumador_id')->references('id')->on('cantidad_fumadores')->onDelete('restrict');
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
        Schema::dropIfExists('habito_fumadores');
    }
}
