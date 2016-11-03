<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHabitoMedicamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habito_medicamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('historia_ocupacional_id')->unsigned();$table->foreign('historia_ocupacional_id')->references('id')->on('historia_ocupacionales')->onDelete('restrict');
            $table->integer('regularidad_medicamento_id')->unsigned();$table->foreign('regularidad_medicamento_id')->references('id')->on('regularidad_medicamentos')->onDelete('restrict');
            $table->string('descripcion');
            $table->string('nombremedicamento');
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
        Schema::dropIfExists('habito_medicamentos');
    }
}
