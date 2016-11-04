<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medico_paciente_id')->unsigned();$table->foreign('medico_paciente_id')->references('id')->on('medico_pacientes')->onDelete('restrict');
            $table->datetime('fechainicio');
            $table->datetime('fechafin');
            $table->string('color');
            $table->string('descripcion');
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
        Schema::dropIfExists('citas');
    }
}

?>