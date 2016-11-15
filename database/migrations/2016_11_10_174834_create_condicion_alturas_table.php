<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCondicionAlturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condicion_alturas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('historia_ocupacional_id')->unsigned();$table->foreign('historia_ocupacional_id')->references('id')->on('historia_ocupacionales')->onDelete('restrict');
            $table->string('condicion',50);
            $table->string('observacion',500);
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
        Schema::dropIfExists('condicion_alturas');
    }
}
