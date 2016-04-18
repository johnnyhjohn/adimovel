<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoas', function(Blueprint $table){
            $table->increments('id');
            $table->string('nome');
            $table->char('tipo_pessoa', 3);
            $table->date('data_nascimento');
            $table->string('cpf', 15)->unique();
            $table->string('rg', 15)->unique()->nullable();
            $table->string('email');
            $table->string('telefone');
            $table->string('cep', 8)->nullable();
            $table->string('endereco')->nullable();
            $table->integer('cidade')->unsigned();
            $table->foreign('cidade')->references('id')->on('cidades');
            $table->boolean('status');
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
        Schema::drop('pessoas');
    }
}
