<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoCondicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_condiciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_examen_id')->unsigned();$table->foreign('tipo_examen_id')->references('id')->on('tipo_examenes')->onDelete('restrict');
            $table->string('descripcion',200);
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
        Schema::dropIfExists('tipo_condiciones');
    }
}
