<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecibo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibo', function(Blueprint $table){
            $table->increments('id');
            $table->integer('mes');
            $table->integer('ano');
            $table->string('descricao');
            $table->double('valor', 20,2);
            $table->date('dia_emissao');
            $table->integer('movimentacao')->unsigned();
            $table->foreign('movimentacao')->references('id')->on('movimentacao');
            $table->integer('proprietario')->unsigned();
            $table->foreign('proprietario')->references('id')->on('pessoa');
            $table->integer('inquilino')->unsigned();
            $table->foreign('inquilino')->references('id')->on('pessoa');
            $table->integer('usuario')->unsigned();
            $table->foreign('usuario')->references('id')->on('usuario');
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
        Schema::drop('recibo');
    }
}
