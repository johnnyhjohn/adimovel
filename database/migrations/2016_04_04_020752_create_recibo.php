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
        Schema::create('recibos', function(Blueprint $table){
            $table->increments('id');
            $table->integer('mes');
            $table->integer('ano');
            $table->string('descricao');
            $table->double('valor', 20,2);
            $table->date('dia_emissao');
            $table->integer('movimentacao')->unsigned();
            $table->foreign('movimentacao')->references('id')->on('movimentacaos');
            $table->integer('proprietario')->unsigned();
            $table->foreign('proprietario')->references('id')->on('pessoas');
            $table->integer('inquilino')->unsigned();
            $table->foreign('inquilino')->references('id')->on('pessoas');
            $table->integer('usuario')->unsigned();
            $table->foreign('usuario')->references('id')->on('usuarios');
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
        Schema::drop('recibos');
    }
}
