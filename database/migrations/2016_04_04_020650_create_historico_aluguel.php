<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoAluguel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_aluguels', function(Blueprint $table){
            $table->increments('id');
            $table->double('valor',20,2);
            $table->date('data_inicio');
            $table->date('data_termino');
            $table->integer('tipo_imovel')->unsigned();
            $table->foreign('tipo_imovel')->references('id')->on('tipo_imovels');
            $table->integer('proprietario')->unsigned();
            $table->foreign('proprietario')->references('id')->on('pessoas');
            $table->integer('inquilino')->unsigned();
            $table->foreign('inquilino')->references('id')->on('pessoas');
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
        Schema::drop('historico_aluguels');
    }
}
