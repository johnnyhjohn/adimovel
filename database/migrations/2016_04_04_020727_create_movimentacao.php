<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimentacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacaos', function(Blueprint $table){
            $table->increments('id');
            $table->integer('mes');
            $table->integer('ano');
            $table->string('descricao');
            $table->double('valor', 20,2);
            $table->date('dia_movimentacao');
            $table->integer('imovel')->unsigned();
            $table->foreign('imovel')->references('id')->on('imovels');
            $table->integer('contrato')->unsigned();
            $table->foreign('contrato')->references('id')->on('contrato_aluguels');
            $table->integer('tipo_movimentacao')->unsigned();
            $table->foreign('tipo_movimentacao')->references('id')->on('tipo_movimentacaos');
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
        Schema::drop('movimentacaos');
    }
}