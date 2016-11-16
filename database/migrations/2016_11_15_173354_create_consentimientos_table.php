<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsentimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consentimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('historia_ocupacional_id')->unsigned();$table->foreign('historia_ocupacional_id')->references('id')->on('historia_ocupacionales')->onDelete('restrict');
            $table->integer('tipo_consentimiento_id')->unsigned();$table->foreign('tipo_consentimiento_id')->references('id')->on('tipo_consentimientos')->onDelete('restrict');
            $table->string('otro');
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
        Schema::dropIfExists('consentimientos');
    }
}
