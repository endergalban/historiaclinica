<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraumatologicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traumatologicos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesion_id')->unsigned();$table->foreign('lesion_id')->references('id')->on('lesiones')->onDelete('restrict');
            $table->integer('antecedente_ocupacional_id')->unsigned();$table->foreign('antecedente_ocupacional_id')->references('id')->on('antecedente_ocupacionales')->onDelete('restrict');
            $table->string('secuela');
            $table->string('otro');
            $table->string('arl');
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
        Schema::dropIfExists('traumatologicos');
    }
}
