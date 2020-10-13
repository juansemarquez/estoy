<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('docentes_id');
            $table->unsignedBigInteger('post_id');
            $table->timestamps();
            $table->foreign('post_id')
                  ->references('id')
                  ->on('posts')
                  ->onDelete('cascade');
            $table->foreign('docentes_id')
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
        Schema::dropIfExists('lecturas');
    }
}
