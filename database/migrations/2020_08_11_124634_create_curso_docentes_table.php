<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursoDocentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso_docentes', function (Blueprint $table) {
            //$table->id();
            $table->unsignedBigInteger('docentes_id');
            $table->unsignedBigInteger('curso_id');
            //$table->timestamps();
            $table->foreign('docentes_id')->references('id')->on('docentes');
            $table->foreign('curso_id')->references('id')->on('cursos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curso_docentes');
    }
}
