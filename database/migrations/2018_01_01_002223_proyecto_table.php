<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProyectoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->date('fecha');
            $table->string('nombre_archivo');
            $table->text('autores');
            $table->text('archivo');
            $table->integer('carrera_id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->integer('categoria_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('proyecto', function (Blueprint $table) {
            $table->foreign('carrera_id')->references('id')->on('carrera');
            $table->foreign('usuario_id')->references('id')->on('usuario');
            $table->foreign('categoria_id')->references('id')->on('categoria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyecto');
    }
}
