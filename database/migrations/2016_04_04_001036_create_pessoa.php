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
            $table->char('tp_pessoa', 3);
            $table->string('nm_pessoa');
            $table->date('dt_nascimento');
            $table->string('nr_cpf', 15)->unique();
            $table->string('nr_rg', 15)->unique()->nullable();
            $table->string('nr_telefone');
            $table->string('email');
            $table->integer('id_cidade')->unsigned();
            $table->foreign('id_cidade')->references('id')->on('cidades');
            $table->string('endereco')->nullable();
            $table->string('bairro')->nullable();
            $table->string('nr_endereco')->nullable();
            $table->string('nr_cep', 8)->nullable();
            $table->boolean('ativo')->default(true);
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
