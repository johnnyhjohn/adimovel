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
            //$table->integer('id_pessoa')->unsigned();
            //$table->foreign('id_pessoa')->references('id')->on('pessoas');
            $table->integer('id_contrato')->unsigned();
            $table->foreign('id_contrato')->references('id')->on('contratos');
            $table->integer('id_imovel')->unsigned();
            $table->foreign('id_imovel')->references('id')->on('imovels');
            $table->integer('mes');
            $table->integer('ano');
            $table->double('valor', 20,2);
            $table->string('descricao');
            $table->date('dt_movimentacao');
            //$table->integer('tp_movimentacao')->unsigned();
            //$table->foreign('tp_movimentacao')->references('id')->on('tipo_movimentacaos');
            $table->text('movimentacoes');
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
