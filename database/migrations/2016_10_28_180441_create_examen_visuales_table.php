<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamenVisualesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examen_visuales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ojo_id')->unsigned();$table->foreign('ojo_id')->references('id')->on('ojos')->onDelete('restrict');
            $table->integer('tipo_examen_visual_id')->unsigned();$table->foreign('tipo_examen_visual_id')->references('id')->on('tipo_examen_visuales')->onDelete('restrict');
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
        Schema::dropIfExists('examen_visuales');
    }
}
