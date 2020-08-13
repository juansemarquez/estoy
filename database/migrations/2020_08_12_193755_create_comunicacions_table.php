<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComunicacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunicacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumno_id');
            $table->unsignedBigInteger('docente_id');
            $table->text('observaciones')->nullable();
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('alumno_id')
                  ->references('id')
                  ->on('alumnos')
                  ->onDelete('restrict');
            $table->foreign('docente_id')
                  ->references('id')
                  ->on('docentes')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comunicacions');
    }
}
