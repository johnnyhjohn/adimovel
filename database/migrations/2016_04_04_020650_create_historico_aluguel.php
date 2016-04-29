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
            $table->integer('id_imovel')->unsigned();
            $table->foreign('id_imovel')->references('id')->on('imovels');
            $table->integer('id_inquilino')->unsigned();
            $table->foreign('id_inquilino')->references('id')->on('pessoas');
            $table->integer('id_proprietario')->unsigned();
            $table->foreign('id_proprietario')->references('id')->on('pessoas');
            $table->double('valor',20,2);
            $table->date('dt_inicio');
            $table->date('dt_termino');
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
