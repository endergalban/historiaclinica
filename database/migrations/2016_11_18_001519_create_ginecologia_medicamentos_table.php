<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGinecologiaMedicamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ginecologia_medicamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('historia_ginecologica_id')->unsigned(); $table->foreign('historia_ginecologica_id')->references('id')->on('historia_ginecologicas')->onDelete('restrict');
            $table->string('descripcion');
            $table->string('dosis');
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
        Schema::dropIfExists('ginecologia_medicamentos');
    }
}
