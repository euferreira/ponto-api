<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePontosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pontos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('entrada1')->nullable();
            $table->dateTime('saida1')->nullable();
            $table->dateTime('entrada2')->nullable();
            $table->dateTime('saida2')->nullable();
            $table->time('hora_extra')->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pontos');
    }
}
